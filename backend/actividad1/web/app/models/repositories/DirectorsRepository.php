<?php

require_once __DIR__ . '/BaseRepository.php';
require_once __DIR__ . '/PeopleRepository.php';
require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/../entities/Director.php';
class DirectorsRepository extends PeopleRepository
{
    private PeopleRepository $peopleRepository;

    public function __construct()
    {
        $this->peopleRepository = new PeopleRepository();
    }

    public function getAll(): array
    {
        return $this->peopleRepository->getDirectors();   //Delego al repositorio de persona
    }

    public function getById(int $personId): Person
    {
        return $this->peopleRepository->getById($personId);
    }

    public function create(object $data): object
    {
        return $this->peopleRepository->create($data);   //Delego al repositorio de persona.
    }

    public function update(object $data): object
    {
        return $this->peopleRepository->update($data);   //Delego al repositorio de persona.
    }

    public function delete(int $directorId): void
    {
        $this->peopleRepository->delete($directorId);
    }
}
