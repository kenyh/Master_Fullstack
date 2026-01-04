<?php

class Database
{
    private static ?PDO $connection = null;

    private function __construct() {} //private para que no se pueda instanciar y funcione como clase estática.

    public static function getConnection(): PDO
    {
        if (self::$connection === null) {

            $dbHost = getenv('DB_HOST');
            $dbDatabase = getenv('DB_DATABASE');
            $dbUser = getenv('DB_USER');
            $dbPassword = getenv('DB_PASSWORD');
            $dbPort = getenv('DB_PORT');
            $dbDriver = getenv('DB_DRIVER');

            $dsn = "$dbDriver:host=$dbHost;port=$dbPort;dbname=$dbDatabase";

            self::$connection = new PDO(
                $dsn,
                $dbUser,
                $dbPassword,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,        //Para que lance PDOException en casos de error.
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,   //Opción por defecto para los ->fetch si no se especifica otra.
                    PDO::ATTR_EMULATE_PREPARES => true,                 //Necesaria para que mysql soporte repetir el mismo parámetro en la consulta.
                ]
            );
        }
        return self::$connection;
    }
}
