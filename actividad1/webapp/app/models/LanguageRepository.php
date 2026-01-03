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
            $language = new Language($fila['language_id'], $fila['name'], $fila['iso_code']);
            array_push($languages, $language);
        }

        return $languages;
    }

    public function getById(int $languageId): Language
    {
        $query = $this->baseQuery . ' AND language_id = :languageId';
        $connection = Database::getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute(["languageId" => $languageId]);

        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC); //Acá fetch all devuelve un array asociativo.
        if (count($filas) === 0) {
            throw new NotFoundException("No se encontró idioma con languageId: " . $languageId);
        }
        $fila = $filas[0];
        $language = new Language($fila['language_id'], $fila['name'], $fila['iso_code']);
        return $language;
    }

    public function create(object $data): object
    {
        $query = 'INSERT into languages(name, iso_code) VALUES(:name,:isocode)';

        $connection = Database::getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute([
            'name' => $data->getName(),
            'isocode' => $data->getIsoCode()
        ]);

        $id = (int) $connection->lastInsertId();

        return $this->getById($id);
    }

    public function update(object $data): object
    {
        $query = 'UPDATE languages SET name = :name, iso_code=:isocode WHERE language_id = :languageId ';

        $connection = Database::getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute([
            'name' => $data->getName(),
            'isocode' => $data->getIsoCode(),
            'languageId' => $data->getLanguageId(),
        ]);

        //FIXME: Aquí podría comprobar que hay un idioma...
        // $filasAfectadas = $stmt->rowCount();
        return $this->getById($data->getLanguageId());
    }

    public function delete(int $languageId): void
    {
        $query = 'DELETE FROM languages WHERE language_id = :languageId ';

        $connection = Database::getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute([
            'languageId' => $languageId,
        ]);
    }
}
