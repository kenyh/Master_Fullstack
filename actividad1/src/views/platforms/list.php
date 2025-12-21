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

    <header class="bg-dark text-center text-white p-2">
        <h1>Plataformas</h1>
    </header>
    <main class="container flex-fill">
        <div class="d-flex justify-content-center p-2"><a href="create.php" class="btn btn-primary">Crear</a></div>
        <div class="d-flex justify-content-center">
            <?php
            $controller = new PlatformController();
            $platforms = $controller->getAll();
            if (count($platforms) > 0) {
            ?>
                <table class="table table-bordered w-auto">
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