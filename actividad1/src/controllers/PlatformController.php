<?php
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/Platform.php';

class PlatformController
{

    private ?PDO $connection = null;

    public function __construct()
    {
        $this->connection = Database::getConnection();
    }

    public function getAll(): array
    {
        $query = 'SELECT * FROM platform ORDER BY "name" ';

        $stmt = $this->connection->prepare($query); //Acá podría pasar parámetros.
        $stmt->execute();

        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $platforms = [];

        foreach ($filas as $fila) {

            $platform = new Platform($fila['platformId'], $fila['name']);
            array_push($platforms, $platform);
        }

        return $platforms;
    }
}
