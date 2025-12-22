<?php
require_once __DIR__ . '/../models/LanguageRepository.php';

function listLanguages()
{
    $languageRepository = new LanguageRepository();
    $languages = $languageRepository->getAll();
    return $languages;
}
