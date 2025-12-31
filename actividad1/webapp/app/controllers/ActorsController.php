<?php
require_once __DIR__ . '/../models/ActorsRepository.php';
require_once 'AbstractController.php';

class ActorsController extends AbstractController
{

    public function __construct()
    {
        parent::__construct(new ActorsRepository());
    }
    public function list()
    {
        $listado = $this->repository->getAll();
        require_once __DIR__ . '/../views/actors/list.php';
    }
    public function create()
    {
        throw new Exception("Not implemented yet");
    }
    public function read()
    {
        throw new Exception("Not implemented yet");
    }
    public function update()
    {
        throw new Exception("Not implemented yet");
    }
    public function delete()
    {
        throw new Exception("Not implemented yet");
    }
}
