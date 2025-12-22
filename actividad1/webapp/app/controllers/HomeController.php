<?php
require_once __DIR__ . '/../models/PlatformsRepository.php';

class HomeController
{

    public function list()
    {
        $controllerName = 'HomeController';
        require_once __DIR__ .  '/../views/index.php';
    }
}
