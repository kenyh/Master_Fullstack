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
            $person = new Person($fila['personId'], $fila['name'], $fila['surname'], $fila['birthday'], $fila['nationality'], $fila['isActor'], $fila['isDirector']);
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

        $people = [];

        foreach ($filas as $fila) {
            $person = new Person($fila['personId'], $fila['name'], $fila['surname'], $fila['birthday'], $fila['nationality'], $fila['isActor'], $fila['isDirector']);
            array_push($people, $person);
        }

        return $people;
    }

    public function getById(int $personId): Person
    {
        $connection = Database::getConnection();

        $query = $this->baseQuery . ' AND "personId" = :personId';
        $stmt = $connection->prepare($query);
        $stmt->execute(["personId" => $personId]);

        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC); //Acá fetch all devuelve un array asociativo.
        if (count($filas) === 0) {
            throw new NotFoundException("No se encontró plataforma con personId: " . $personId);
        }
        $fila = $filas[0];
        $person = new Person($fila['personId'], $fila['name'], $fila['surname'], $fila['birthday'], $fila['nationality'], $fila['isActor'], $fila['isDirector']);
        return $person;
    }

    public function create(object $data): object
    {

        $connection = Database::getConnection();
        try {
            $connection->beginTransaction();       //Transacción ya que son dos inserts separados.
            $query = 'INSERT into people(name, surname, birthday,nationality) VALUES(:name,:surname,:birthday, :nationality)';
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
        $connection = Database::getConnection();
        $connection->beginTransaction();       //Transacción ya que son dos inserts separados.
        try {
            $person = $this->getById($data->getPersonId());
            $query = 'UPDATE people SET "name" = :name, "surname"=:surname, "birthday"=:birthday , "nationality"=:nationality  WHERE "personId" = :personId ';
            $stmt = $connection->prepare($query);
            $stmt->execute([
                'personId' => $data->getPersonId(),
                'name' => $data->getName(),
                'surname' => $data->getSurname(),
                'birthday' => $data->getBirthday(),
                'nationality' => $data->getNationality(),
            ]);

            if ($person->isDirector() !== $data->isDirector()) { //Si cambió el director:
                $query = 'INSERT INTO directors ("directorId") VALUES (:directorId)';   //Por defecto asumo que no era director y ahora lo es.
                if ($person->isDirector()) { //Si actualmente es director, hay que hacer delete, xq cambió.
                    $query = 'DELETE FROM directors WHERE "directorId" = :directorId';
                }
                $stmt = $connection->prepare($query);
                $stmt->execute([
                    'directorId' => $person->getPersonId(),
                ]);
            }

            if ($person->isActor() !== $data->isActor()) { //Si cambió el actor:
                $query = 'INSERT INTO actors ("actorId") VALUES (:actorId)';   //Por defecto asumo que no era actor y ahora lo es.
                if ($person->isActor()) { //Si actualmente es actor, hay que hacer delete, xq cambió.
                    $query = 'DELETE FROM actors WHERE "actorId" = :actorId';
                }
                $stmt = $connection->prepare($query);
                $stmt->execute([
                    'actorId' => $person->getPersonId(),
                ]);
            }

            //FIXME: Aquí podría comprobar que hay un idioma...
            // $filasAfectadas = $stmt->rowCount();
            $connection->commit();
            return $this->getById($data->getPersonId());
        } catch (Throwable $e) {
            $connection->rollBack();
            throw $e;
        }
    }

    public function delete(int $personId): void
    {
        $connection = Database::getConnection();
        $query = 'DELETE FROM people WHERE "personId" = :personId ';   //Es suficiente con borrar people por el cascade.
        $stmt = $connection->prepare($query);
        $stmt->execute([
            'personId' => $personId,
        ]);
    }
}
