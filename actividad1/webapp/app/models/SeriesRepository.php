<?php

require_once __DIR__ . '/BaseRepository.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Serie.php';
class SeriesRepository extends BaseRepository
{

    protected string $baseQuery = '
        WITH myseries AS (
            SELECT S.*, P.name as platform, PE.surname as director
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
            $serie = new Serie($fila['serie_id'], $fila['title'], $fila['platform_id'], $fila['director_id'], $fila["platform"], $fila["director"]);
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
        $serie = new Serie($fila['serie_id'], $fila['title'], $fila['platform_id'], $fila['director_id'], $fila["platform"], $fila["director"]);
        return $serie;
    }

    public function create(object $data): object
    {
        $query = 'INSERT into series(title, platform_id,director_id) VALUES(:title,:platformId, :directorId)';

        $connection = Database::getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute([
            'title' => $data->getTitle(),
            'platformId' => $data->getPlatformId(),
            'directorId' => $data->getDirectorId(),
        ]);

        $id = (int) $connection->lastInsertId();

        return $this->getById($id);
    }

    public function update(object $data): object
    {
        $query = 'UPDATE series SET "title" = :title, platform_id=:platformId, director_id=:directorId WHERE serie_id = :serieId ';

        $connection = Database::getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute([
            'serieId' => $data->getSerieId(),
            'title' => $data->getTitle(),
            'platformId' => $data->getPlatformId(),
            'directorId' => $data->getDirectorId(),
        ]);
        return $this->getById($data->getSerieId());
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
}
