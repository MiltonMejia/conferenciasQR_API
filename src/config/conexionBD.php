<?php

/**
 * Creacion y manipulacion de conexiones a la Base de Datos
 *
 * PHP version minima: 5 
 *
 * @category Authentication
 * @package  Conexion
 * @author   Milton Jeonathan Mejia Fabian
**/

class Conexion{

    private $usuario;
    private $contrasena;
    private $servidor;
    private $basedatos;
    private $port;
    private $conexion;
    private $tabla;

    function __construct($credenciales)
    {
        $this->usuario = $credenciales['usuario'];
        $this->contrasena = $credenciales['contrasena'];
        $this->servidor = $credenciales['servidor'];
        $this->basedatos = $credenciales['baseDatos'];
        $this->port = $credenciales['port'];
        $this->crearConexion();
    }
    
    public function obtenerResultados($cmdSQL)
    {
        $consulta = $this->conexion->prepare($cmdSQL);
        $this->ejecutarConsulta($consulta);
        return $this->tabla;
    }

    public function obtenerResultados_bindParam($cmdSQL, $param){
        $consulta = $this->conexion->prepare($cmdSQL);
        $consulta->bind_param($param[0], ...$param[1]);
        $this->ejecutarConsulta($consulta);
        return $this->tabla;
    }

    private function ejecutarConsulta($cmdSQL)
    {
        $cmdSQL->execute();
        $this->tabla = $cmdSQL->get_result();
        $cmdSQL->close();
    }

    public function insertarDatos($cmdSQL, $param)
    {
        $consulta = $this->conexion->prepare($cmdSQL);
        $consulta->bind_param($param[0], ...$param[1]);

        if($consulta->execute())
        {
            $id = $consulta->insert_id;
            $consulta->close();
            return $id;
        }
        else
        {
            $consulta->close();
            return false;
        }
    }

    private function cerrarConexion()
    {
        $this->conexion->close();
    }

    private function crearConexion()
    {
        $this->conexion = new mysqli($this->servidor,$this->usuario,$this->contrasena,$this->basedatos,$this->port);
        $this->conexion->set_charset("utf8");
        if(!$this->conexion->connect_error)
        {
            return $this->conexion;
        }
        else
        {
            return false;
        }
    }

}
