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
                            <form action="/platforms/delete" method="POST" class="btn-group" role="group" onsubmit="return confirm('¿Estás seguro que deseas borrar la plataforma <?php echo $fila->getName() ?> ?')">
                                <a href="update?platformId=<?php echo $fila->getPlatformId() ?>" class="btn btn-success">Editar</a>
                                <input type="hidden" name="platformId" value="<?php echo $fila->getPlatformId() ?>" />
                                <input type="submit" value="Borrar" class="btn btn-danger" />
                            </form>
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