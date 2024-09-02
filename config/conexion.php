<?php

class conexion
{
    private static $instancia;
    private $pdo;

    private function __construct()
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=proyectobd', 'root', '');
    }

    public static function obtenerInstacia()
    {
        if (!isset(self::$instancia)) {
            self::$instancia = new conexion();
        }
        return self::$instancia->pdo;
    }
}
