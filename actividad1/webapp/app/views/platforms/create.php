<?php
require_once __DIR__ . '/../top.php';
?>
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


<?php
require_once __DIR__ . '/../bottom.php';
?>