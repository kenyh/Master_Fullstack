<?php require_once __DIR__ . '/../../controllers/PlatformController.php'; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plataformas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="d-flex flex-column min-vh-100">

    <nav class="d-flex justify-content-center py-3">
        <ul class="nav nav-pills">
            <li class="nav-item"><a href="/" class="nav-link">Home</a></li>
            <li class="nav-item"><a href="/views/platforms/list.php" class="nav-link active">Plataformas</a></li>
            <li class="nav-item"><a href="/views/languages/list.php" class="nav-link">Idiomas</a></li>
            <li class="nav-item"><a href="/views/directors/list.php" class="nav-link">Directores</a></li>
            <li class="nav-item"><a href="/views/actors/list.php" class="nav-link">Actores</a></li>
            <li class="nav-item"><a href="/views/series/list.php" class="nav-link">Series</a></li>
        </ul>
    </nav>

    <header>
        <H1>Crear plataforma</H1>
    </header>
    <main class="container flex-fill">
        <div class="d-flex justify-content-center">
            <form name="create_platform" action="" method="POST">
                <div class="row">
                    <div class="col mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" placeholder="Nombre de la plataforma" required minlength="2" />
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <input type="submit" class="btn btn-primary" value="Guardar" />
                    </div>
                </div>
            </form>
        </div>

    </main>
    <footer class=" bg-light text-center py-2">
        <small>Backend - Grupo 11 - Actividad 1</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>