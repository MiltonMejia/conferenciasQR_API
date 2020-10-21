<?php

use const Conferencias\Config\credenciales;

class ResolveAdministrativo
{

    private $conexion;

    function __construct()
    {
        $this->conexion = new Conexion(credenciales);
    }

    public function obtenerAdministrativo($usuario, $contrasena)
    {

        $cmdSQL = "SELECT * FROM `administradores` INNER JOIN privilegios ON administradores.id_privilegio = privilegios.id_privilegio WHERE nombre_admin = ? AND contra = ?";
        $param = ['ss', [$usuario,$contrasena]];
        $tabla = $this->conexion->obtenerResultados_bindParam($cmdSQL, $param);

        if(mysqli_num_rows($tabla) > 0)
        {
            foreach($tabla as $fila)
            {
                $token = new Token();
                $token->generarTokenAdministrativo($fila['nombre_admin'],$fila['contra'],$fila['id_privilegio']);
                return
                [
                    'usuario' => $fila['nombre_admin'],
                    'privilegio' => $fila['id_privilegio'],
                ];
            }
        }
        else
        {
            throw new ErrorAdministrativoInvalido;
        }
    }

    public function obtenerAdministrativoToken($usuario)
    {

        $cmdSQL = "SELECT * FROM `administradores` INNER JOIN privilegios ON administradores.id_privilegio = privilegios.id_privilegio WHERE nombre_admin = ?";
        $param = ['s', [$usuario]];
        $tabla = $this->conexion->obtenerResultados_bindParam($cmdSQL, $param);

        if(mysqli_num_rows($tabla) > 0)
        {
            foreach($tabla as $fila)
            {
                return
                [
                    'usuario' => $fila['nombre_admin'],
                    'contrasena' => $fila['contra'],
                    'privilegio' => $fila['id_privilegio'],
                ];
            }
        }
        else
        {
            throw new ErrorAdministrativoInvalido;
        }
    }

}