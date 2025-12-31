<?php
require_once __DIR__ . '/../top.php';
?>
<div class="d-flex justify-content-center p-2"><a href="create" class="btn btn-primary">Crear</a></div>
<div class="d-flex justify-content-center">
    <?php
    if (count($listado) > 0) {
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
                foreach ($listado as $fila):
                ?>
                    <tr>
                        <th scope="row"><?php echo $fila->getPlatformId() ?></th>
                        <td><?php echo $fila->getName() ?></td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="update?platformId=<?php echo $fila->getPlatformId() ?>" class="btn btn-success">Editar</a>
                                <a href="delete.php?platformId=<?php echo $fila->getPlatformId() ?>" class="btn btn-danger">Borrar</a>
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


<?php
require_once __DIR__ . '/../bottom.php';
?>