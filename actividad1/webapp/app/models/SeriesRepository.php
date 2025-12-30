<?php

require_once __DIR__ . '/BaseRepository.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Serie.php';
class SeriesRepository extends BaseRepository
{

    public function getAll(): array
    {
        $query = 'SELECT * FROM series ORDER BY "title" ';

        /** @var PDO $connection */
        $connection = Database::getConnection();
        $stmt = $connection->prepare($query); //Acá podría pasar parámetros.
        $stmt->execute();

        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $series = [];

        foreach ($filas as $fila) {
            $serie = new Serie($fila['serieId'], $fila['title']);
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
