<?php

require_once __DIR__ . '/BaseRepository.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Language.php';
class LanguageRepository extends BaseRepository
{

    protected string $baseQuery = '
        WITH mylanguages AS (
            SELECT * FROM languages ORDER BY "name"
        )
        SELECT * FROM mylanguages
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


    public function getById(int $languageId): Language
    {
        $query = $this->baseQuery . ' AND "languageId" = :languageId';
        $connection = Database::getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute(["languageId" => $languageId]);

        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC); //Acá fetch all devuelve un array asociativo.
        if (count($filas) === 0) {
            throw new NotFoundException("No se encontró plataforma con languageId: " . $languageId);
        }
        $fila = $filas[0];
        $language = new Language($fila['languageId'], $fila['name'], $fila['iso_code']);
        return $language;
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
