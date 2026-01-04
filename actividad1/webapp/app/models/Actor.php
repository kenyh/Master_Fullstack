<?php


require_once __DIR__ . '/Person.php';

class Actor extends Person
{

    public function getActorId(): int
    {
        return $this->getPersonId();
    }

    public function setActorId(int $actorId)
    {
        $this->setPersonId($actorId);
    }
}
