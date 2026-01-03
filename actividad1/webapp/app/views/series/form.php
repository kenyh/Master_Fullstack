<form class="card" name="create_serie" action="" method="POST">
    <div class="card-body">
        <div class="row">
            <div class="col mb-3">
                <label for="title" class="form-label">Título</label>
                <input type="text" class="form-control" name="title" placeholder="Introduce el título" required minlength="2" value="<?php echo $serie?->getTitle() ?? '' ?>" />
            </div>
        </div>
        <div class="row">
            <div class="col mb-3">
                <label for="platformId" class="form-label">Plataforma</label>
                <select class="form-select" name="platformId">
                    <option value="">Selecciona la plataforma</option>
                    <?php foreach ($platforms as $platform): ?>
                        <option value="<?php echo $platform->getPlatformId() ?>"
                            <?php echo $serie?->getPlatformId() === $platform->getPlatformId() ? 'selected' : '' ?>>
                            <?php echo $platform->getName()  ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col mb-3">
                <label for="directorId" class="form-label">Director</label>
                <select class="form-select" name="directorId">
                    <option value="">Selecciona el director</option>
                    <?php foreach ($directors as $director): ?>
                        <option value="<?php echo $director->getDirectorId() ?>"
                            <?php echo $serie?->getDirectorId() === $director->getDirectorId() ? 'selected' : '' ?>>
                            <?php echo $director->getSurname() . ", " . $director->getName() ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="row ">
            <div class="col mb-3 btn-group" role="group">
                <input type="submit" class="btn btn-primary" id="saveBtn" value="Guardar" />
                <a href="/series/list" class="btn btn-warning">Cancelar</a>
            </div>
        </div>
    </div>
</form>