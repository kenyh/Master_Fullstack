<?php
require_once __DIR__ . '/../app/controllers/Router.php';

//Iniciamos la sesión para pasar el message después de cambiarnos de página.
if (session_status() === PHP_SESSION_NONE) session_start();

Router::route();

//En este punto ya se generó la vista, así que podemos borrar el mensaje.
//Si hicimos redirect, no llega a este punto, por lo que no borra el mensaje.
unset($_SESSION['message']);
