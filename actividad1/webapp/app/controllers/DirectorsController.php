<?php
require_once __DIR__ . '/../models/DirectorsRepository.php';
require_once 'AbstractController.php';

class DirectorsController extends AbstractController
{

    public function __construct()
    {
        parent::__construct(new DirectorsRepository());
    }
    public function list()
    {
        $listado = $this->repository->getAll();
        require_once __DIR__ . '/../views/directors/list.php';
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
