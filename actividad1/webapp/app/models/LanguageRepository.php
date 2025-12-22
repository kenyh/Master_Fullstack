<?php

require_once __DIR__ . '/BaseRepository.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Language.php';
class LanguageRepository extends BaseRepository
{

    public function getAll(): array
    {
        $query = 'SELECT * FROM languages ORDER BY "name" ';

        /** @var PDO $connection */
        $connection = Database::getConnection();
        $stmt = $connection->prepare($query); //Acá podría pasar parámetros.
        $stmt->execute();

        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $languages = [];

        foreach ($filas as $fila) {
            $language = new Language($fila['languageId'], $fila['name'], $fila['iso_code']);
            array_push($languages, $language);
        }

        return $languages;
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
