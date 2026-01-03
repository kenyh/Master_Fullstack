<?php

require_once __DIR__ . '/BaseRepository.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Serie.php';
class SeriesRepository extends BaseRepository
{

    protected string $baseQuery = '
        WITH myseries AS (
            SELECT S.*, P.name as platform, PE.surname as director,
            
            -- Audios
            (
                SELECT JSON_ARRAYAGG(L.iso_code) 
                FROM series_audio_languages SAL 
                JOIN languages L ON L.language_id = SAL.language_id 
                WHERE SAL.serie_id = S.serie_id
            ) AS audio_language_names,
            (
                SELECT JSON_ARRAYAGG(SAL.language_id) 
                FROM series_audio_languages SAL 
                WHERE SAL.serie_id = S.serie_id
            ) AS audio_language_ids,
            -- Subtítulos
            (
                SELECT JSON_ARRAYAGG(L.iso_code) 
                FROM series_subtitle_languages SSL 
                JOIN languages L ON L.language_id = SSL.language_id 
                WHERE SSL.serie_id = S.serie_id
            ) AS subtitle_language_names,
            (
                SELECT JSON_ARRAYAGG(SSL.language_id) 
                FROM series_subtitle_languages SSL 
                WHERE SSL.serie_id = S.serie_id
            ) AS subtitle_language_ids
            FROM series S 
            LEFT JOIN platforms P ON S.platform_id = P.platform_id
            LEFT JOIN directors D ON S.director_id = D.director_id
            JOIN people PE ON D.director_id = PE.person_id
            ORDER BY S.title 
        )
        SELECT * FROM myseries
        WHERE TRUE
    ';

    public function getAll(): array
    {
        $query = $this->baseQuery;

        /** @var PDO $connection */
        $connection = Database::getConnection();
        $stmt = $connection->prepare($query); //Acá podría pasar parámetros.
        $stmt->execute();

        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $series = [];

        foreach ($filas as $fila) {
            // $serie = new Serie($fila['serie_id'], $fila['title'], $fila['platform_id'], $fila['director_id'], $fila["platform"], $fila["director"]);
            $serie = $this->filaToSerie($fila);
            array_push($series, $serie);
        }

        return $series;
    }

    public function getById(int $serieId): Serie
    {
        $query = $this->baseQuery . ' AND serie_id = :serieId';
        $connection = Database::getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute(["serieId" => $serieId]);

        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC); //Acá fetch all devuelve un array asociativo.
        if (count($filas) === 0) {
            throw new NotFoundException("No se encontró plataforma con serieId: " . $serieId);
        }
        $fila = $filas[0];
        // $serie = new Serie($fila['serie_id'], $fila['title'], $fila['platform_id'], $fila['director_id'], $fila["platform"], $fila["director"]);
        $serie = $this->filaToSerie($fila);
        return $serie;
    }

    public function create(object $data): object
    {

        $connection = Database::getConnection();

        try {
            $connection->beginTransaction();
            $query = 'INSERT into series(title, platform_id,director_id) VALUES(:title,:platformId, :directorId)';

            $stmt = $connection->prepare($query);
            $stmt->execute([
                'title' => $data->getTitle(),
                'platformId' => $data->getPlatformId(),
                'directorId' => $data->getDirectorId(),
            ]);

            $id = (int) $connection->lastInsertId();

            //Insertar los idiomas de audio y subtítulos, como es create no hay que borrar nada.
            $languageIds = $data->getAudioLanguageIds();
            $values = [];
            $params = [];
            foreach ($languageIds as $i => $languageId) {
                $values[] = "(:serieId, :languageId{$i})";
                $params["languageId{$i}"] = $languageId;
            }
            $params['serieId'] = $id;
            $sql = 'INSERT INTO series_audio_languages (serie_id, language_id) VALUES ' . implode(', ', $values);
            $stmt = $connection->prepare($sql);
            $stmt->execute($params);

            $languageIds = $data->getSubtitleLanguageIds();
            $values = [];
            $params = [];
            foreach ($languageIds as $i => $languageId) {
                $values[] = "(:serieId, :languageId{$i})";
                $params["languageId{$i}"] = $languageId;
            }
            $params['serieId'] = $id;
            $sql = 'INSERT INTO series_subtitle_languages (serie_id, language_id) VALUES ' . implode(', ', $values);
            $stmt = $connection->prepare($sql);
            $stmt->execute($params);

            $connection->commit();
            return $this->getById($id);
        } catch (Exception $e) {
            $connection->rollBack();
            throw $e;
        }
    }

    public function update(object $data): object
    {

        $connection = Database::getConnection();
        try {
            $connection->beginTransaction();
            $query = '
            WITH borrar_audio AS (
                DELETE FROM series_audio_languages WHERE serie_id = :serieId
            ), borrar_subtitulos AS (
                DELETE FROM series_subtitle_languages WHERE serie_id = :serieId
            )
            UPDATE series SET "title" = :title, platform_id=:platformId, director_id=:directorId WHERE serie_id = :serieId ';

            $stmt = $connection->prepare($query);
            $stmt->execute([
                'serieId' => $data->getSerieId(),
                'title' => $data->getTitle(),
                'platformId' => $data->getPlatformId(),
                'directorId' => $data->getDirectorId(),
            ]);

            //Insertar los idiomas de audio y subtítulos, arriba ya se borraron todos para la serie.
            $languageIds = $data->getAudioLanguageIds();
            $values = [];
            $params = [];
            foreach ($languageIds as $i => $languageId) {
                $values[] = "(:serieId, :languageId{$i})";
                $params["languageId{$i}"] = $languageId;
            }
            $params['serieId'] = $data->getSerieId();
            $sql = 'INSERT INTO series_audio_languages (serie_id, language_id) VALUES ' . implode(', ', $values);
            $stmt = $connection->prepare($sql);
            $stmt->execute($params);

            $languageIds = $data->getSubtitleLanguageIds();
            $values = [];
            $params = [];
            foreach ($languageIds as $i => $languageId) {
                $values[] = "(:serieId, :languageId{$i})";
                $params["languageId{$i}"] = $languageId;
            }
            $params['serieId'] = $data->getSerieId();
            $sql = 'INSERT INTO series_subtitle_languages (serie_id, language_id) VALUES ' . implode(', ', $values);
            $stmt = $connection->prepare($sql);
            $stmt->execute($params);
            $connection->commit();
            return $this->getById($data->getSerieId());
        } catch (Exception $e) {
            $connection->rollBack();
            throw $e;
        }
    }

    public function delete(int $serieId): void
    {
        $query = 'DELETE FROM series WHERE serie_id = :serieId ';

        $connection = Database::getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute([
            'serieId' => $serieId,
        ]);
    }

    private function filaToSerie(array $fila): Serie
    {
        $audioLanguageNames = json_decode($fila['audio_language_names'], true) ?? [];
        $subtitleLanguageNames = json_decode($fila['subtitle_language_names'], true) ?? [];
        $audioLanguageIds = json_decode($fila['audio_language_ids'], true) ?? [];
        $subtitleLanguageIds = json_decode($fila['subtitle_language_ids'], true) ?? [];

        return new Serie(
            $fila['serie_id'],
            $fila['title'],
            $fila['platform_id'],
            $fila['director_id'],
            $audioLanguageIds,
            $subtitleLanguageIds,
            $audioLanguageNames,
            $subtitleLanguageNames,
            $fila['platform'],
            $fila['director']
        );
    }
}
