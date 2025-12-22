<?php
require_once __DIR__ . '/top.php';
?>
<div class="row border">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 mb-2">
    <div class="card border-primary border-3 shadow">
      <div class="card-body">
        <h5 class="card-title">Plataformas</h5>
        <p class="card-text">Una exaustiva lista de plataformas de streaming disponibles actualmente para ver todas tus series favoritas.</p>
        <a href="/views/platforms/list.php" class="btn btn-primary">Ir al listado</a>
      </div>
    </div>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 mb-2">
    <div class="card border-primary border-3 shadow">
      <div class="card-body">
        <h5 class="card-title">Idiomas</h5>
        <p class="card-text">Lista de idiomas disponibles en las series.</p>
        <a href="/views/languages/list.php" class="btn btn-primary">Ir al listado</a>
      </div>
    </div>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 mb-2">
    <div class="card border-primary border-3 shadow">
      <div class="card-body">
        <h5 class="card-title">Directores</h5>
        <p class="card-text">Lista de directores.</p>
        <a href="/views/directors/list.php" class="btn btn-primary">Ir al listado</a>
      </div>
    </div>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 mb-2">
    <div class="card border-primary border-3 shadow">
      <div class="card-body">
        <h5 class="card-title">Actores y actrices</h5>
        <p class="card-text">Lista de actores y actrices.</p>
        <a href="/views/actors/list.php" class="btn btn-primary">Ir al listado</a>
      </div>
    </div>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 mb-2">
    <div class="card border-primary border-3 shadow">
      <div class="card-body">
        <h5 class="card-title">Series</h5>
        <p class="card-text">Lista de series disponibles.</p>
        <a href="/views/series/list.php" class="btn btn-primary">Ir al listado</a>
      </div>
    </div>
  </div>
</div>
</div>
<?php
require_once __DIR__ . '/bottom.php';
?>