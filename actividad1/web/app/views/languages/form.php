<form class="card" name="create_language" action="" method="POST">
    <div class="card-body">
        <div class="row">
            <div class="col mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="name" placeholder="Introduce el lenguaje" required minlength="2" value="<?php echo $language?->getName() ?? '' ?>" />
            </div>
        </div>
        <div class="row">
            <div class="col mb-3">
                <label for="isoCode" class="form-label">Código ISO</label>
                <input type="text" class="form-control" name="isoCode" placeholder="Introduce el código ISO" required minlength="2" maxlength="2" value="<?php echo $language?->getIsoCode() ?? '' ?>" />
            </div>
        </div>
        <div class="row ">
            <div class="col mb-3 btn-group" role="group">
                <input type="submit" class="btn btn-primary" id="saveBtn" value="Guardar" />
                <a href="/languages/list" class="btn btn-warning">Cancelar</a>
            </div>
        </div>
    </div>
</form>