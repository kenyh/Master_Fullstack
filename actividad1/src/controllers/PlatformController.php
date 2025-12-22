<?php
require_once __DIR__ . '/../models/PlatformRepository.php';

function listPlatforms()
{
    $platformRepository = new PlatformRepository();
    $platforms = $platformRepository->getAll();
    return $platforms;  
}   
