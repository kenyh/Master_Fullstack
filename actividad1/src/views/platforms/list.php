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
        <H1>Listado de plataformas</H1>
    </header>
    <main class="container flex-fill">
        <div class="d-flex justify-content-center p-2"><a href="create.php" class="btn btn-primary">Crear</a></div>
        <div class="d-flex justify-content-center">
            <?php
            $controller = PlatformController::getInstance();
            $platforms = $controller->getAll();
            if (count($platforms) > 0) {
            ?> <table class="table table-bordered w-auto">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($platforms as $platform):
                        ?>
                            <tr>
                                <th scope="row"><?php echo $platform->getPlatformId() ?></th>
                                <td><?php echo $platform->getName() ?></td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="edit.php?platformId=<?php echo $platform->getPlatformId() ?>" class="btn btn-success">Editar</a>
                                        <a href="delete.php?platformId=<?php echo $platform->getPlatformId() ?>" class="btn btn-danger">Borrar</a>
                                    </div>

                                </td>
                            </tr>
                        <?php
                        endforeach;
                        ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <div class="alert alert-warning">Aún no hay plataformas</div>
            <?php } ?>
        </div>

    </main>
    <footer class="bg-light text-center py-2">
        <small>Backend - Grupo 11 - Actividad 1</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>