<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Platforms</h1>
    <ul>
        <?php 
            require_once __DIR__ . '/../../controllers/PlatformController.php';

            $controller = new PlatformController();
            $platforms = $controller->getAll();
            foreach ($platforms as $platform): 
        ?>
                <li>
                    <?php echo $platform->getPlatformId() . ":" . $platform->getName()  ?>
                </li>
        <?php 
            endforeach; 
        ?>
    </ul>
</body>
</html>