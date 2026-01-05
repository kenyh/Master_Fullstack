<?php

require_once __DIR__ . '/Person.php';

class Director extends Person
{
    public function __construct(
        ?int $personId,
        string $name,
        string $surname,
        string $birthday,
        string $nationality,
        bool $isActor,
        bool $isDirector
    ) {
        if (!$isActor && !$isDirector) throw new Exception("La persona debe ser director y/o actor");

        $this->personId = $personId;
        $this->name = $name;
        $this->surname = $surname;
        $this->birthday = $birthday;
        $this->nationality = $nationality;
        $this->isActor = $isActor;
        $this->isDirector = $isDirector;
    }

    public function getDirectorId(): int
    {
        return $this->getPersonId();
    }

    public function setDirectorId(int $directorId)
    {
        $this->setPersonId($directorId);
    }
}
