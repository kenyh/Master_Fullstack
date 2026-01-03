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
            LEFT JOIN platforms P ON S."platformId" = P."platformId"
            LEFT JOIN directors D ON S."directorId" = D."directorId"
            JOIN person PE ON D."directorId" = PE."personId"
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
            $serie = new Serie($fila['serieId'], $fila['title'], $fila['platformId'], $fila['directorId'], $fila["platform"], $fila["director"]);
            array_push($series, $serie);
        }

        return $series;
    }

    public function getById(int $serieId): Serie
    {
        $query = $this->baseQuery . ' AND "serieId" = :serieId';
        $connection = Database::getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute(["serieId" => $serieId]);

        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC); //Acá fetch all devuelve un array asociativo.
        if (count($filas) === 0) {
            throw new NotFoundException("No se encontró plataforma con serieId: " . $serieId);
        }
        $fila = $filas[0];
        $serie = new Serie($fila['serieId'], $fila['title'], $fila['platformId'], $fila['directorId'], $fila["platform"], $fila["director"]);
        return $serie;
    }

    public function create(object $data): object
    {
        $query = 'INSERT into series(title, "platformId","directorId") VALUES(:title,:platformId, :directorId)';

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
        $query = 'UPDATE series SET "title" = :title, "platformId"=:platformId, "directorId"=:directorId WHERE "serieId" = :serieId ';

        $connection = Database::getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute([
            'serieId' => $data->getSerieId(),
            'title' => $data->getTitle(),
            'platformId' => $data->getPlatformId(),
            'directorId' => $data->getDirectorId(),
        ]);

        //FIXME: Aquí podría comprobar que hay un idioma...
        // $filasAfectadas = $stmt->rowCount();
        return $this->getById($data->getSerieId());
    }

    public function delete(int $serieId): void
    {
        $query = 'DELETE FROM series WHERE "serieId" = :serieId ';

        $connection = Database::getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute([
            'serieId' => $serieId,
        ]);
    }
}
