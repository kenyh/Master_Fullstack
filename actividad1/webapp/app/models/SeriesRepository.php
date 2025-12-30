<?php

require_once __DIR__ . '/BaseRepository.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Serie.php';
class SeriesRepository extends BaseRepository
{

    public function getAll(): array
    {
        $query = '--sql
            SELECT S.*, P.name as platform, PE.surname as director
            FROM series S 
            LEFT JOIN platforms P ON S."platformId" = P."platformId"
            LEFT JOIN directors D ON S."directorId" = D."directorId"
            JOIN person PE ON D."directorId" = PE."personId"
        ';

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
