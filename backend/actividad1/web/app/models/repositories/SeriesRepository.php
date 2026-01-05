<?php

require_once __DIR__ . '/BaseRepository.php';
require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/../entities/Serie.php';
class SeriesRepository extends BaseRepository
{

    protected string $baseQuery = '
        WITH myseries AS (
            SELECT S.*, P.name as platform, PE.surname as director,
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
            (
                SELECT JSON_ARRAYAGG(SA.actor_id) 
                FROM serie_actors SA 
                WHERE SA.serie_id = S.serie_id
            ) AS actor_ids,
            (
                SELECT JSON_ARRAYAGG(L.iso_code) 
                FROM series_subtitle_languages SL 
                JOIN languages L ON L.language_id = SL.language_id 
                WHERE SL.serie_id = S.serie_id
            ) AS subtitle_language_names,
            (
                SELECT JSON_ARRAYAGG(SL.language_id) 
                FROM series_subtitle_languages SL 
                WHERE SL.serie_id = S.serie_id
            ) AS subtitle_language_ids,
            (
                SELECT JSON_ARRAYAGG(CONCAT_WS(\' \',PE.name, PE.surname)) 
                FROM serie_actors SA
                JOIN actors AC ON SA.actor_id = AC.actor_id
                JOIN people PE ON AC.actor_id = PE.person_id 
                WHERE SA.serie_id = S.serie_id
            ) AS actor_names
            FROM series S 
            LEFT JOIN platforms P ON S.platform_id = P.platform_id
            LEFT JOIN directors D ON S.director_id = D.director_id
            JOIN people PE ON D.director_id = PE.person_id
        )
        SELECT * FROM myseries
        WHERE 1=1
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
            $query = 'INSERT into series(title,synopsis, platform_id,director_id) VALUES(:title,:synopsis,:platformId, :directorId)';

            $stmt = $connection->prepare($query);
            $stmt->execute([
                'title' => $data->getTitle(),
                'synopsis' => $data->getSynopsis(),
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


            $actorIds = $data->getActorIds();
            $values = [];
            $params = [];
            foreach ($actorIds as $i => $actorId) {
                $values[] = "(:serieId, :actorId{$i})";
                $params["actorId{$i}"] = $actorId;
            }
            $params['serieId'] = $id;
            $sql = 'INSERT INTO serie_actors (serie_id, actor_id) VALUES ' . implode(', ', $values);
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

            //Borro todos los idiomas de audio.
            $query = 'DELETE FROM series_audio_languages WHERE serie_id = :serieId';
            $stmt = $connection->prepare($query);
            $stmt->execute([
                'serieId' => $data->getSerieId()
            ]);

            //Borro todos los idiomas de subtitulos.
            $query = 'DELETE FROM series_subtitle_languages WHERE serie_id = :serieId';
            $stmt = $connection->prepare($query);
            $stmt->execute([
                'serieId' => $data->getSerieId()
            ]);

            //Borro todos los actores.
            $query = 'DELETE FROM serie_actors WHERE serie_id = :serieId';
            $stmt = $connection->prepare($query);
            $stmt->execute([
                'serieId' => $data->getSerieId()
            ]);

            $query = 'UPDATE series SET title = :title, synopsis = :synopsis, platform_id=:platformId, director_id=:directorId WHERE serie_id = :serieId ';

            $stmt = $connection->prepare($query);
            $stmt->execute([
                'serieId' => $data->getSerieId(),
                'title' => $data->getTitle(),
                'synopsis' => $data->getSynopsis(),
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

            $actorIds = $data->getActorIds();
            $values = [];
            $params = [];
            foreach ($actorIds as $i => $actorId) {
                $values[] = "(:serieId, :actorId{$i})";
                $params["actorId{$i}"] = $actorId;
            }
            $params['serieId'] = $data->getSerieId();
            $sql = 'INSERT INTO serie_actors (serie_id, actor_id) VALUES ' . implode(', ', $values);
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
        $actorIds = json_decode($fila['actor_ids'], true) ?? [];
        $actorNames = json_decode($fila['actor_names'], true) ?? [];
        return new Serie(
            $fila['serie_id'],
            $fila['title'],
            $fila['synopsis'],
            $fila['platform_id'],
            $fila['director_id'],
            $audioLanguageIds,
            $subtitleLanguageIds,
            $actorIds,
            $audioLanguageNames,
            $subtitleLanguageNames,
            $actorNames,
            $fila['platform'],
            $fila['director']
        );
    }
}
