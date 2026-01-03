<?php

require_once __DIR__ . '/BaseRepository.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Platform.php';
class PlatformsRepository extends BaseRepository
{
    protected string $baseQuery = '
        WITH MyP AS (
            SELECT * FROM platforms ORDER BY name 
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
            $platform = new Platform($fila['platform_id'], $fila['name']);
            array_push($platforms, $platform);
        }

        return $platforms;
    }

    public function getById(int $platformId): Platform
    {
        $query = $this->baseQuery . ' AND platform_id = :platformId';
        $connection = Database::getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute(["platformId" => $platformId]);

        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC); //Acá fetch all devuelve un array asociativo.
        if (count($filas) === 0) {
            throw new NotFoundException("No se encontró plataforma con platformId: " . $platformId);
        }
        $fila = $filas[0];
        $platform = new Platform($fila['platform_id'], $fila['name']);
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
        $query = 'UPDATE platforms SET name = :name WHERE platform_id = :platformId ';

        $connection = Database::getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute([
            'name' => $data->getName(),
            'platformId' => $data->getPlatformId(),
        ]);

        //FIXME: Aquí podría comprobar que hay una plataforma...
        // $filasAfectadas = $stmt->rowCount();
        return $this->getById($data->getPlatformId());
    }

    public function delete(int $platformId): void
    {
        $query = 'DELETE FROM platforms WHERE platform_id = :platformId ';

        $connection = Database::getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute([
            'platformId' => $platformId,
        ]);
    }
}
