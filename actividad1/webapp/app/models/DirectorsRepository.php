<?php

require_once __DIR__ . '/BaseRepository.php';
require_once __DIR__ . '/PeopleRepository.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Director.php';
class DirectorsRepository extends PeopleRepository
{
    public function getAll(): array
    {
        return parent::getBy(["isDirector" => true]);
    }

    public function getById(int $personId): Director
    {
        $query = $this->baseQuery . ' AND "personId" = :personId';
        $connection = Database::getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute(["personId" => $personId]);

        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC); //Acá fetch all devuelve un array asociativo.
        if (count($filas) === 0) {
            throw new NotFoundException("No se encontró plataforma con personId: " . $personId);
        }
        $fila = $filas[0];
        $director = new Director($fila['personId'], $fila['name'], $fila['surname'], $fila['birthday'], $fila['nationality'], $fila['isActor'], $fila['isDirector']);
        return $director;
    }

    public function create(object $data): object
    {
        return parent::create($data);
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
