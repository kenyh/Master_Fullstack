<?php

class Database
{
    private static ?PDO $connection = null;

    private function __construct() {} //private para que no se pueda instanciar y funcione como clase estática.

    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            $dsn = 'pgsql:host=' . getenv('PGHOST') . ';port=5432;dbname=actividad1';

            self::$connection = new PDO(
                $dsn,
                'actividad1',
                'actividad1',
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]
            );
        }
        return self::$connection;
    }
}
