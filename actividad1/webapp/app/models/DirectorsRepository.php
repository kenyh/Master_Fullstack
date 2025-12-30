<?php

require_once __DIR__ . '/BaseRepository.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Director.php';
class DirectorsRepository extends BaseRepository
{

    public function getAll(): array
    {
        $query = 'SELECT * FROM directors D JOIN person P ON P."personId" = D."directorId" ORDER BY "name" ';

        /** @var PDO $connection */
        $connection = Database::getConnection();
        $stmt = $connection->prepare($query); //Acá podría pasar parámetros.
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
