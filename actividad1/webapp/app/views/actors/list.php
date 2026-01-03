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
                    <th scope="col">Apellido</th>
                    <th scope="col">Nacimiento</th>
                    <th scope="col">Nacionalidad</th>
                    <th scope="col">Director?</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($listado as $fila):
                ?>
                    <tr>
                        <th scope="row"><?php echo $fila->getPersonId() ?></th>
                        <td><?php echo $fila->getName() ?></td>
                        <td><?php echo $fila->getSurname() ?></td>
                        <td><?php echo $fila->getBirthday() ?></td>
                        <td><?php echo $fila->getNationality() ?></td>
                        <td><?php echo $fila->isDirector() ? "SI" : "NO" ?></td>
                        <td>
                            <form action="/actors/delete" method="POST" class="btn-group" role="group" onsubmit="return confirm('¿Estás seguro que deseas borrar la persona <?php echo $fila->getName() ?> ?')">
                                <a href="/actors/update?actorId=<?php echo $fila->getPersonId() ?>" class="btn btn-success">Editar</a>
                                <input type="hidden" name="actorId" value="<?php echo $fila->getPersonId() ?>" />
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