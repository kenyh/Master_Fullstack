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
                    value="<?php echo $person?->getName() ?? '' ?>" />
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
                    value="<?php echo $person?->getSurname() ?? '' ?>" />
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
                    value="<?php echo $person?->getBirthday() ?? '' ?>" />
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
                    value="<?php echo $person?->getNationality() ?? '' ?>" />
            </div>
        </div>
        <div class="row ">
            <div class="col mb-3 btn-group" role="group">
                <input type="submit" class="btn btn-primary" id="saveBtn" value="Guardar" />
                <a href="/persons/list" class="btn btn-warning">Cancelar</a>
            </div>
        </div>
    </div>
</form>