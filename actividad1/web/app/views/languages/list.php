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
                    <th scope="col">ISO Code</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($listado as $fila):
                ?>
                    <tr>
                        <th scope="row"><?php echo $fila->getLanguageId() ?></th>
                        <td><?php echo $fila->getName() ?></td>
                        <td><?php echo $fila->getIsoCode() ?></td>
                        <td>
                            <form action="/languages/delete" method="POST" class="btn-group" role="group" onsubmit="return confirm('¿Estás seguro que deseas borrar el idioma <?php echo $fila->getName() ?> ?')">
                                <a href="update?languageId=<?php echo $fila->getLanguageId() ?>" class="btn btn-success">Editar</a>
                                <input type="hidden" name="languageId" value="<?php echo $fila->getLanguageId() ?>" />
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
        <div class="alert alert-warning">Aún no hay Idiomas</div>
    <?php } ?>
</div>


<?php
require_once __DIR__ . '/../bottom.php';
?>