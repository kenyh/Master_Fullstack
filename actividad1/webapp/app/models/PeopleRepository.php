<?php

require_once __DIR__ . '/BaseRepository.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Director.php';
class PeopleRepository extends BaseRepository
{

    protected string $baseQuery = '
        WITH mypersons as (
            SELECT P.*, D.*,A.*
            , D."directorId" IS NOT NULL as  "isDirector"
            , A."actorId" IS NOT NULL as  "isActor"
            FROM people P 
            LEFT JOIN directors D ON P."personId" = D."directorId" 
            LEFT JOIN actors A ON P."personId" = A."actorId" 
            ORDER BY "surname" 
        )
        SELECT * FROM mypersons
        WHERE TRUE
    ';

    public function getAll(): array
    {
        $query = $this->baseQuery;

        $connection = Database::getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute();

        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $people = [];

        foreach ($filas as $fila) {
            $director = new Person($fila['directorId'], $fila['name'], $fila['surname'], $fila['birthday'], $fila['nationality'], $fila['isActor'], $fila['isDirector']);
            array_push($people, $person);
        }

        return $people;
    }

    public function getBy(array $filter): array
    {
        $query = $this->baseQuery;
        $params = [];

        foreach ($filter as $key => $value) {
            if (empty($value)) { //Ojo el empty que no es solo caso null.
                continue;
            }

            $query .= " AND \"$key\" = :$key";
            $params[$key] = $value;
        }

        $connection = Database::getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute($params);

        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $directors = [];

        foreach ($filas as $fila) {
            $director = new Person($fila['directorId'], $fila['name'], $fila['surname'], $fila['birthday'], $fila['nationality'], $fila['isActor'], $fila['isDirector']);
            array_push($directors, $director);
        }

        return $directors;
    }

    public function getById(int $personId): Person
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
        $person = new Person($fila['directorId'], $fila['name'], $fila['surname'], $fila['birthday'], $fila['nationality'], $fila['isActor'], $fila['isDirector']);
        return $person;
    }

    public function create(object $data): object
    {

        $connection = Database::getConnection();
        try {
            $query = 'INSERT into people(name, surname, birthday,nationality) VALUES(:name,:surname,:birthday, :nationality)';
            $connection->beginTransaction();       //Transacción ya que son dos inserts separados.
            $stmt = $connection->prepare($query);
            $stmt->execute([
                'name' => $data->getName(),
                'surname' => $data->getSurname(),
                'birthday' => $data->getBirthday(),
                'nationality' => $data->getNationality(),
            ]);

            $personId = (int) $connection->lastInsertId();
            if ($data->isDirector()) {  //Si es director, insert en directors
                $queryDirector = '
                    INSERT INTO directors ("directorId")
                    VALUES (:directorId)
                ';

                $stmt = $connection->prepare($queryDirector);
                $stmt->execute([
                    'directorId' => $personId
                ]);
            }
            if ($data->isActor()) {     //Si es actor, insert en actors
                $queryActor = '
                    INSERT INTO actors ("actorId")
                    VALUES (:actorId)
                ';

                $stmt = $connection->prepare($queryActor);
                $stmt->execute([
                    'actorId' => $personId
                ]);
            }
            $connection->commit();
            return $this->getById($personId);
        } catch (Throwable $e) {    //Así me permite hacer un solo catch para cualquier excepción?
            $connection->rollBack();
            throw $e;
        }
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
