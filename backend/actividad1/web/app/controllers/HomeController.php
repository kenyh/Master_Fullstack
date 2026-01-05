<?php
require_once __DIR__ . '/../models/repositories/PlatformsRepository.php';

class HomeController
{

    public function list()
    {
        require_once __DIR__ .  '/../views/index.php';
    }
}
