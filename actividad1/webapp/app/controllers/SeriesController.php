<?php
require_once __DIR__ . '/../models/SeriesRepository.php';
require_once 'AbstractController.php';

class SeriesController extends AbstractController
{

    public function __construct()
    {
        parent::__construct(new SeriesRepository());
    }
    public function list()
    {
        $listado = $this->repository->getAll();
        require_once __DIR__ . '/../views/series/list.php';
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
