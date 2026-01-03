<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo  ucwords(Router::$method . " " . Router::$controllerName)  ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="d-flex flex-column min-vh-100">

    <nav class="d-flex justify-content-center py-3">
        <ul class="nav nav-pills">
            <li class="nav-item"><a href="/" class="nav-link <?php echo Router::$controllerName === 'Home' ? 'active' : ''; ?> "> Home</a></li>
            <li class="nav-item"><a href="/platforms/" class="nav-link <?php echo Router::$controllerName === 'Platforms' ? 'active' : ''; ?> ">Plataformas</a></li>
            <li class="nav-item"><a href="/languages/" class="nav-link <?php echo Router::$controllerName === 'Languages' ? 'active' : ''; ?> ">Idiomas</a></li>
            <li class="nav-item"><a href="/directors/" class="nav-link <?php echo Router::$controllerName === 'Directors' ? 'active' : ''; ?> ">Directores</a></li>
            <li class="nav-item"><a href="/actors/" class="nav-link <?php echo Router::$controllerName === 'Actors' ? 'active' : ''; ?> ">Actores</a></li>
            <li class="nav-item"><a href="/series/" class="nav-link <?php echo Router::$controllerName === 'Series' ? 'active' : ''; ?> ">Series</a></li>
        </ul>
    </nav>
    <?php if (isset($_SESSION['message'])) { ?>
        <div class="alert alert-<?php echo $_SESSION['message']["type"] ?> d-flex align-items-center" role="alert">
            <div>
                <?php echo $_SESSION['message']["text"] ?>
            </div>
        </div>
    <?php } else { ?>
        no hay mensajes
    <?php } ?>
    <header>
        <H1>Biblioteca de Series</H1>
    </header>
    <main class="container-fluid flex-fill">