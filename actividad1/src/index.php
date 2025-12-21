<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Actividad 1</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="d-flex flex-column min-vh-100">

  <nav class="d-flex justify-content-center py-3">
    <ul class="nav nav-pills">
      <li class="nav-item"><a href="/" class="nav-link active">Home</a></li>
      <li class="nav-item"><a href="/views/platforms/list.php" class="nav-link">Plataformas</a></li>
      <li class="nav-item"><a href="/views/languages/list.php" class="nav-link">Idiomas</a></li>
      <li class="nav-item"><a href="/views/directors/list.php" class="nav-link">Directores</a></li>
      <li class="nav-item"><a href="/views/actors/list.php" class="nav-link">Actores</a></li>
      <li class="nav-item"><a href="/views/series/list.php" class="nav-link">Series</a></li>
    </ul>
  </nav>
  <header>
    <H1>Biblioteca de Series</H1>
  </header>
  <main class="container flex-fill">
    <div class="row">
      <div class="col-xs-12 col-sm-6 col-md-4 col-log-3 col-xl-2 col-xxl-1">
        <div class="card border-primary">
          <div class="card-body">
            <h5 class="card-title">Plataformas</h5>
            <p class="card-text">Una exaustiva lista de plataformas de streaming disponibles actualmente para ver todas tus series favoritas.</p>
            <a href="/views/platforms/list.php" class="btn btn-primary">Ir al listado</a>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-4 col-log-3 col-xl-2 col-xxl-1">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Idiomas</h5>
            <p class="card-text">Lista de idiomas disponibles en las series.</p>
            <a href="/views/languages/list.php" class="btn btn-primary">Ir al listado</a>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-4 col-log-3 col-xl-2 col-xxl-1">
        Directores
      </div>
      <div class="col-xs-12 col-sm-6 col-md-4 col-log-3 col-xl-2 col-xxl-1">
        Actores y actrices
      </div>
      <div class="col-xs-12 col-sm-6 col-md-4 col-log-3 col-xl-2 col-xxl-1">
        Series
      </div>
    </div>
    </div>
  </main>
  <footer class="bg-light text-center py-2">
    <small>Backend - Grupo 11 - Actividad 1</small>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>