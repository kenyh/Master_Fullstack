<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actividad 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="d-flex flex-column min-vh-100">

    <nav class="d-flex justify-content-center py-3">
        <ul class="nav nav-pills">
            <li class="nav-item"><a href="/" class="nav-link <?php echo $controllerName === 'HomeController' ? 'active' : ''; ?> "> Home</a></li>
            <li class="nav-item"><a href="/platforms/list" class="nav-link <?php echo $controllerName === 'PlatformsController' ? 'active' : ''; ?> ">Plataformas</a></li>
            <li class="nav-item"><a href="/languages/list" class="nav-link <?php echo $controllerName === 'LanguagesController' ? 'active' : ''; ?> ">Idiomas</a></li>
            <li class="nav-item"><a href="/directors/list" class="nav-link <?php echo $controllerName === 'DirectorsController' ? 'active' : ''; ?> ">Directores</a></li>
            <li class="nav-item"><a href="/actors/list" class="nav-link <?php echo $controllerName === 'ActorsController' ? 'active' : ''; ?> ">Actores</a></li>
            <li class="nav-item"><a href="/series/list" class="nav-link <?php echo $controllerName === 'SeriesController' ? 'active' : ''; ?> ">Series</a></li>
        </ul>
    </nav>
    <header>
        <H1>Biblioteca de Series</H1>
    </header>
    <main class="container-fluid flex-fill">