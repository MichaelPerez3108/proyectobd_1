<?php

require_once("../model/model.php");

//Esta clase la extendemos de la clase padre model.php
//esta clase combina algo de DAO y DTO
class Clientes extends Model{

    // Aca definimos un poco de DTO, los atributos
    private $Cedula;
    private $Nombres;
    private $Apellidos;
    private $Direccion;
    private $Ubicacion;


    public function __construct($cedula, $nombres, $apellidos, $direccion, $ubicacion){
        parent::__construct();
        $this->Cedula = $cedula;
        $this->Nombres = $nombres;
        $this->Apellidos = $apellidos;
        $this->Direccion = $direccion;
        $this->Ubicacion = $ubicacion;
    }

    //Definimos los Getters
    public function getCedula(){
        return $this->Cedula;
    }

    public function getNombres(){
        return $this->Nombres;
    }

    public function getApellidos(){
        return $this->Apellidos;
    }

    public function getDireccion(){
        return $this->Direccion;
    }

    public function getUbicacion(){
        return $this->Cedula;
    }

    //Definimos los Setters
    public function setCedula(int $cedula){
        $this->Cedula = $cedula;
    }

    public function setNombres(string $nombres){
        $this->Nombres = $nombres;
    }

    public function setApellidos(string $apellidos){
        $this->Apellidos = $apellidos;
    }

    public function setDireccion(string $direccion){
        $this->Direccion = $direccion;
    }

    public function setUbicacion(string $ubicacion){
        $this->Ubicacion = $ubicacion;
    }
// Metodos de DAO, porque son ya de logica a acceso de la base de datos

    protected function getSelectQuery($coordenadas): string
    {
        return 'SELECT clientes.Cedula, clientes.Nombres, clientes.Apellidos, clientes.Direccion, ST_Distance_Sphere(Ubicacion, POINT('.$coordenadas.')) as Distancia FROM clientes ORDER BY Distancia ASC';
    }

    protected function getInsertQuery(): string{
        return 'INSERT INTO clientes (Cedula, Nombres, Apellidos, Direccion, Ubicacion) VALUES (:cedula, :nombres, :apellidos, :direccion, Point(:lng, :lat))';
    }

    protected function createPDO(PDOStatement $statement): PDOStatement {
        $lng = explode(',', $this->Ubicacion)[0];
        $lat = explode(',', $this->Ubicacion)[1];
        
        $statement->bindParam(':cedula', $this->Cedula, PDO::PARAM_INT);
        $statement->bindParam(':nombres', $this->Nombres, PDO::PARAM_STR);
        $statement->bindParam(':apellidos', $this->Apellidos, PDO::PARAM_STR);
        $statement->bindParam(':direccion', $this->Direccion, PDO::PARAM_STR);
        $statement->bindParam(':lng', $lng, PDO::PARAM_STR);
        $statement->bindParam(':lat', $lat, PDO::PARAM_STR);
        
        return $statement;
    }
    
    
}