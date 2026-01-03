<form class="card" name="create_person" action="" method="POST">
    <div class="card-body">
        <div class="row">
            <div class="col mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input
                    type="text"
                    class="form-control"
                    name="name"
                    placeholder="Introduce el nombre de la persona"
                    required
                    minlength="2"
                    value="<?php echo $actor?->getName() ?? '' ?>" />
            </div>
        </div>
        <div class="row">
            <div class="col mb-3">
                <label for="surname" class="form-label">Apellido</label>
                <input
                    type="text"
                    class="form-control"
                    name="surname"
                    placeholder="Introduce el apellido de la persona"
                    required
                    minlength="2"
                    value="<?php echo $actor?->getSurname() ?? '' ?>" />
            </div>
        </div>
        <div class="row">
            <div class="col mb-3">
                <label for="birthday" class="form-label">Fecha de nacimiento</label>
                <input
                    type="date"
                    class="form-control"
                    name="birthday"
                    placeholder="Introduce la fecha de nacimiento"
                    required
                    minlength="2"
                    value="<?php echo $actor?->getBirthday() ?? '' ?>" />
            </div>
        </div>
        <div class="row">
            <div class="col mb-3">
                <label for="nationality" class="form-label">Nacionalidad</label>
                <input
                    type="text"
                    class="form-control"
                    name="nationality"
                    placeholder="Introduce la nacionalidad de la persona"
                    required
                    minlength="2"
                    value="<?php echo $actor?->getNationality() ?? '' ?>" />
            </div>
        </div>
        <div class="row">
            <div class="col mb-3">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="isDirector" value="1" <?php if (isset($actor) && $actor->isDirector()) echo 'checked' ?>>
                    <label class="form-check-label" for="isDirector">Director</label>
                </div>
            </div>
            <div class="col mb-3">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="isActor" value="1" <?php if (isset($actor) && $actor->isActor()) echo 'checked' ?>>
                    <label class="form-check-label" for="isActor">Actor</label>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col mb-3 btn-group" role="group">
                <input type="submit" class="btn btn-primary" id="saveBtn" value="Guardar" />
                <a href="/actors/list" class="btn btn-warning">Cancelar</a>
            </div>
        </div>
    </div>
</form>