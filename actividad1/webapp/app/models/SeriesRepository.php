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

    public function getByIds(array $ids): array
    {
        return [];
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
        $serie = new Serie($fila['serieId'], $fila['name'], $fila['surname'], $fila['birthday'], $fila['nationality']);
        return $serie;
    }

    public function create(object $data): object
    {
        throw new \Exception("No implementado");
    }

    public function update(object $data): object
    {
        throw new \Exception("No implementado");
    }

    public function delete(int $id): void
    {
        throw new \Exception("No implementado");
    }
}
