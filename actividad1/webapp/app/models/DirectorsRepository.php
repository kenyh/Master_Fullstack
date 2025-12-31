<?php

require_once __DIR__ . '/BaseRepository.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Director.php';
class DirectorsRepository extends BaseRepository
{

    protected string $baseQuery = '
        WITH mydirectors as (
            SELECT * FROM directors D JOIN person P ON P."personId" = D."directorId" ORDER BY "name" 
        )
        SELECT * FROM mydirectors
        WHERE TRUE
    ';

    public function getAll(): array
    {
        $query = $this->baseQuery;

        /** @var PDO $connection */
        $connection = Database::getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute();

        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $directors = [];

        foreach ($filas as $fila) {
            $director = new Director($fila['directorId'], $fila['name'], $fila['surname'], $fila['birthday'], $fila['nationality']);
            array_push($directors, $director);
        }

        return $directors;
    }

    public function getByIds(array $ids): array
    {
        return [];
    }


    public function getById(int $directorId): Director
    {
        $query = $this->baseQuery . ' AND "directorId" = :directorId';
        $connection = Database::getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute(["directorId" => $directorId]);

        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC); //Acá fetch all devuelve un array asociativo.
        if (count($filas) === 0) {
            throw new NotFoundException("No se encontró plataforma con directorId: " . $directorId);
        }
        $fila = $filas[0];
        $director = new Director($fila['directorId'], $fila['name'], $fila['surname'], $fila['birthday'], $fila['nationality']);
        return $director;
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
