<?php

require_once __DIR__ . '/BaseRepository.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Actor.php';
class ActorsRepository extends BaseRepository
{
    protected string $baseQuery = '
        WITH myactors AS (
            SELECT * FROM actors JOIN person P ON P."personId" = actors."actorId" ORDER BY "name" 
        )
        SELECT * FROM myactors
        WHERE TRUE
    ';

    public function getAll(): array
    {
        $query = $this->baseQuery;
        $connection = Database::getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute();

        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $actors = [];

        foreach ($filas as $fila) {
            $actor = new Actor($fila['actorId'], $fila['name'], $fila['surname'], $fila['birthday'], $fila['nationality']);
            array_push($actors, $actor);
        }

        return $actors;
    }

    public function getByIds(array $ids): array
    {
        return [];
    }

    public function getById(int $actorId): Actor
    {
        $query = $this->baseQuery . ' AND "actorId" = :actorId';
        $connection = Database::getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute(["actorId" => $actorId]);

        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC); //Acá fetch all devuelve un array asociativo.
        if (count($filas) === 0) {
            throw new NotFoundException("No se encontró plataforma con actorId: " . $actorId);
        }
        $fila = $filas[0];
        $actor = new Actor($fila['actorId'], $fila['name'], $fila['surname'], $fila['birthday'], $fila['nationality']);
        return $actor;
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
