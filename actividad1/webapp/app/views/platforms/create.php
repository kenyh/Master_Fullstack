<?php
require_once __DIR__ . '/../top.php';

?>
<div class="d-flex justify-content-center">
    <form class="card" name="create_platform" action="" method="POST">
        <div class="card-body">
            <div class="row">
                <div class="col mb-3">
                    <label for="name" class="form-label">Nombre de la plataforma</label>
                    <input type="text" class="form-control" name="name" placeholder="Introduce el nombre de la plataforma" required minlength="2" />
                </div>
            </div>
            <div class="row ">
                <div class="col mb-3 btn-group" role="group">
                    <input type="submit" class="btn btn-primary" id="saveBtn" value="Guardar" />
                    <a href="/platforms/list" class="btn btn-warning">Cancelar</a>
                </div>
            </div>
        </div>
    </form>
</div>


<?php
require_once __DIR__ . '/../bottom.php';
?>