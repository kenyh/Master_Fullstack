<?php

require_once __DIR__ . '/BaseRepository.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Platform.php';
class PlatformsRepository extends BaseRepository
{
    private string $baseQuery = '
        WITH MyP AS (
            SELECT * FROM platforms ORDER BY "name" 
        )
        SELECT * FROM MyP
        WHERE TRUE
    ';

    public function getAll(): array
    {

        $connection = Database::getConnection();
        $stmt = $connection->prepare($this->baseQuery); //Acá podría pasar parámetros.
        $stmt->execute();

        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $platforms = [];

        foreach ($filas as $fila) {
            $platform = new Platform($fila['platformId'], $fila['name']);
            array_push($platforms, $platform);
        }

        return $platforms;
    }

    public function getByIds(array $ids): array
    {
        return [];
    }


    public function getById(int $id): Platform
    {
        $query = $this->baseQuery . ' AND "platformId"=$1';
        $connection = Database::getConnection();
        $stmt = $connection->prepare($this->baseQuery); //Acá podría pasar parámetros.
        $stmt->execute();

        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $platform = new Platform($filas[0]['platformId'], $filas[0]['name']);

        return $platform;
    }

    public function create(object $data): Platform
    {
        $query = 'INSERT into platforms(name) VALUES(:name)';

        $connection = Database::getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute([
            'name' => $data->getName()
        ]);

        $id = (int) $connection->lastInsertId();

        return $this->getById($id);
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
