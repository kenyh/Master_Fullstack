<?php

class Director
{
    private int $directorId;
    private string $name;
    private string $surname;
    private string $birthday;   //FIXME: debería ser Date??
    private string $nationality;

    public function __construct(
        int $directorId,
        string $name,
        string $surname,
        string $birthday,
        string $nationality
    ) {
        $this->directorId = $directorId;
        $this->name = $name;
        $this->surname = $surname;
        $this->birthday = $birthday;
        $this->nationality = $nationality;
    }

    public function getDirectorId(): int
    {
        return $this->directorId;
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

    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }
    public function setBirthday(?string $birthday): void
    {
        $this->birthday = $birthday;
    }
    public function setNationality(?string $nationality): void
    {
        $this->nationality = $nationality;
    }
}
