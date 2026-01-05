<?php

class Person
{
    protected ?int $personId;
    protected string $name;
    protected string $surname;
    protected string $birthday;   //FIXME: debería ser Date??
    protected string $nationality;
    protected bool $isActor;
    protected bool $isDirector;

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

    public function getPersonId(): int
    {
        return $this->personId;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getSurname(): string
    {
        return $this->surname;
    }
    public function getBirthday(): string
    {
        return $this->birthday;
    }
    public function getNationality(): string
    {
        return $this->nationality;
    }

    public function isActor(): bool
    {
        return $this->isActor;
    }

    public function isDirector(): bool
    {
        return $this->isDirector;
    }

    public function setPersonId(int $personId): void
    {
        $this->personId = $personId;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }
    public function setBirthday(string $birthday): void
    {
        $this->birthday = $birthday;
    }
    public function setNationality(string $nationality): void
    {
        $this->nationality = $nationality;
    }

    public function setIsActor(bool $isActor)
    {
        $this->isActor = $isActor;
    }
    public function setIsDirector(bool $isDirector)
    {
        $this->isDirector = $isDirector;
    }
}
