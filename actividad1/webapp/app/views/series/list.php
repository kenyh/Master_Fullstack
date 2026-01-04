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
                    <th scope="col">Plataforma</th>
                    <th scope="col">Director</th>
                    <th scope="col">Audios</th>
                    <th scope="col">Subtitulos</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listado as $fila): ?>
                    <tr>
                        <th scope="row"><?php echo $fila->getSerieId() ?></th>
                        <td><?php echo $fila->getTitle() ?></td>
                        <td><?php echo $fila->getPlatform() ?></td>
                        <td><?php echo $fila->getDirector() ?></td>
                        <td><?php echo implode(', ', $fila->getAudioLanguageNames()) ?></td>
                        <td><?php echo implode(', ', $fila->getSubtitleLanguageNames()) ?></td>
                        <td>
                            <form action="/series/delete" method="POST" class="btn-group" role="group" onsubmit="return confirm('¿Estás seguro que deseas borrar la serie <?php echo $fila->getTitle() ?> ?')">
                                <a href="update?serieId=<?php echo $fila->getSerieId() ?>" class="btn btn-success">Editar</a>
                                <input type="hidden" name="serieId" value="<?php echo $fila->getSerieId() ?>" />
                                <input type="submit" value="Borrar" class="btn btn-danger" />
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php } else { ?>
        <div class="alert alert-warning">Aún no hay series</div>
    <?php } ?>
</div>


<?php
require_once __DIR__ . '/../bottom.php';
?>