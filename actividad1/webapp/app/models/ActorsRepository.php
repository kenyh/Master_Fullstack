<?php

require_once __DIR__ . '/BaseRepository.php';
require_once __DIR__ . '/PeopleRepository.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Actor.php';
class ActorsRepository extends PeopleRepository
{
    public function getAll(): array
    {
        return parent::getBy(["isActor" => true]);   //Delego al repositorio de persona
    }

    public function getById(int $personId): Person
    {
        return parent::getById($personId);
    }

    public function create(object $data): object
    {
        return parent::create($data);   //Delego al repositorio de persona.
    }

    public function update(object $data): object
    {
        return parent::update($data);   //Delego al repositorio de persona.
    }

    public function delete(int $actorId): void
    {
        parent::delete($actorId);
    }
}
