<?php

require_once __DIR__ . '/BaseRepository.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Actor.php';
class ActorsRepository extends BaseRepository
{

    public function getAll(): array
    {
        $query = 'SELECT * FROM actors JOIN person P ON P."personId" = actors."actorId" ORDER BY "name" ';

        /** @var PDO $connection */
        $connection = Database::getConnection();
        $stmt = $connection->prepare($query); //Acá podría pasar parámetros.
        $stmt->execute();

        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $platforms = [];

        foreach ($filas as $fila) {
            $platform = new Actor($fila['actorId'], $fila['name'], $fila['surname'], $fila['birthday'], $fila['nationality']);
            array_push($platforms, $platform);
        }

        return $platforms;
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
