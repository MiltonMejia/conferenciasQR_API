<?php

use const Conferencias\Config\credenciales;

class ResolveEstado{

    private $conexion;

    function __construct(){
        $this->conexion = new Conexion(credenciales);
    }

    public function obtenerTotalEstados()
    {

        $cmdSQL = "SELECT * FROM estados ORDER BY nombre_estado";
        $tabla = $this->conexion->obtenerResultados($cmdSQL);

        foreach($tabla as $fila)
        {
            $resultado[] =
            [
                'id' => $fila['id_estado'],
                'nombre' => $fila['nombre_estado']
            ];
        }
        return $resultado;
    }
    
}