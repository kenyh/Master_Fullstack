<?php
require_once __DIR__ . '/../models/PlatformsRepository.php';
require_once 'AbstractController.php';

class PlatformsController extends AbstractController
{

    public function __construct()
    {
        parent::__construct(new PlatformsRepository());
    }
    public function list()
    {
        $listado = $this->repository->getAll();
        $controllerName = 'PlatformsController';
        require_once __DIR__ . '/../views/platforms/list.php';
    }
    public function create()
    {
        $listado = $this->repository->getAll();
        $controllerName = 'PlatformsController';
        require_once __DIR__ . '/../views/platforms/create.php';
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
