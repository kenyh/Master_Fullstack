<?php

require_once __DIR__ . '/BaseRepository.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Director.php';
class PeopleRepository extends BaseRepository
{

    protected string $baseQuery = '
        WITH mypersons as (
            SELECT * FROM people D JOIN people P ON P."personId" = D."directorId" ORDER BY "name" 
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
        //
        $query = 'INSERT into directors(name, "isoCode") VALUES(:name,:isocode)';

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
        $query = 'UPDATE directors SET "name" = :name, "isoCode"=:isocode WHERE "languageId" = :languageId ';

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
        $query = 'DELETE FROM directors WHERE "languageId" = :languageId ';

        $connection = Database::getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute([
            'languageId' => $languageId,
        ]);
    }
}
