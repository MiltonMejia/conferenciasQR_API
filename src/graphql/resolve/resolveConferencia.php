<?php

use const Conferencias\Config\credenciales;

class ResolveConferencia{

    private $conexion;

    function __construct()
    {
        $this->conexion = new Conexion(credenciales);
    }

    public function obtenerTotalConferencias()
    {
        $token = new Token();
        $token->verificarTokenAdministrativo();
        $cmdSQL = "SELECT id_conferencia, nombre_conferencia, tipo_conferencias.nombre, obligatoria FROM conferencias INNER JOIN tipo_conferencias ON conferencias.id_tipoConferencia = tipo_conferencias.id_tipoConferencia ORDER BY conferencias.id_conferencia";
        $tabla = $this->conexion->obtenerResultados($cmdSQL);

        foreach($tabla as $fila)
        {
            $resultado[] =
            [
                'id' => $fila['id_conferencia'],
                'nombre' => $fila['nombre_conferencia'],
                'tipoConferencia' => $fila['nombre'],
                'obligatorio' => $fila['obligatoria']
            ];
        }
        return $resultado;
    }

    public function obtenerConferencia($idConferencia)
    {
        $token = new Token();
        $token->verificarTokenAdministrativo();
        $cmdSQL = "SELECT id_conferencia, nombre_conferencia, tipo_conferencias.nombre, obligatoria FROM conferencias INNER JOIN tipo_conferencias ON conferencias.id_tipoConferencia = tipo_conferencias.id_tipoConferencia WHERE id_conferencia = ? ORDER BY conferencias.id_conferencia";
        $param = ['i', [$idConferencia]];
        $tabla = $this->conexion->obtenerResultados_bindParam($cmdSQL, $param);
        
        foreach($tabla as $fila)
        {
            return
            [
                'id' => $fila['id_conferencia'],
                'nombre' => $fila['nombre_conferencia'],
                'tipoConferencia' => $fila['nombre'],
                'obligatorio' => $fila['obligatoria']
            ];
        }
    }

    public function obtenerConferenciaAsistente($id)
    {
        $token = new Token();
        $token->verificarTokenAdministrativo();
        $cmdSQL = "SELECT conferencias_asistentes.id_conferencia, conferencias.nombre_conferencia, tipo_conferencias.nombre, conferencias.obligatoria, conferencias_asistentes.horario_salida FROM conferencias_asistentes INNER JOIN  conferencias ON conferencias_asistentes.id_conferencia = conferencias.id_conferencia INNER JOIN tipo_conferencias ON conferencias.id_tipoConferencia = tipo_conferencias.id_tipoConferencia WHERE id_confAsist = ? ORDER BY id_conferencia";
        $param = ['i', [$id]];
        $tabla = $this->conexion->obtenerResultados_bindParam($cmdSQL, $param);

        foreach($tabla as $fila)
        {
            return
            [
                'id' => $fila['id_conferencia'],
                'nombre' => $fila['nombre_conferencia'],
                'tipoConferencia' => $fila['nombre'],
                'obligatorio' => $fila['obligatoria'],
                'horaRegistro' => $fila['horario_salida']
            ];
        }
    }

    public function obtenerTotalConferenciasAsistente($id, $existeToken)
    {
        if($existeToken)
        {
            $token = new Token();
            $token->verificarTokenAdministrativo();
        }
        $cmdSQL = "SELECT conferencias_asistentes.id_conferencia, conferencias.nombre_conferencia, tipo_conferencias.nombre, conferencias.obligatoria, UNIX_TIMESTAMP(conferencias_asistentes.horario_salida) FROM conferencias_asistentes INNER JOIN  conferencias ON conferencias_asistentes.id_conferencia = conferencias.id_conferencia INNER JOIN tipo_conferencias ON conferencias.id_tipoConferencia = tipo_conferencias.id_tipoConferencia WHERE id_asistente = ? ORDER BY id_conferencia";
        $param = ['i', [$id]];
        $tabla = $this->conexion->obtenerResultados_bindParam($cmdSQL, $param);
        $resultado = array();

        foreach($tabla as $fila)
        {
            $resultado[] =
            [
                'id' => $fila['id_conferencia'],
                'nombre' => $fila['nombre_conferencia'],
                'tipoConferencia' => $fila['nombre'],
                'obligatorio' => $fila['obligatoria'],
                'horaRegistro' => $fila['UNIX_TIMESTAMP(conferencias_asistentes.horario_salida)']
            ];
        }
        return $resultado;
    }

    public function insertarConferencia($datosConferencia)
    {
        $token = new Token();
        $token->verificarTokenAdministrativo();
        $cmdSQL = "INSERT INTO conferencias(nombre_conferencia,obligatoria,id_tipoConferencia) VALUES(?,?,?)";
        $param = ['sii',[$datosConferencia['nombre'], intval($datosConferencia['obligatorio']), $datosConferencia['tipoConferencia']]];
        $resultado = $this->conexion->insertarDatos($cmdSQL, $param);

        if($resultado != false)
        {
            return $this->obtenerConferencia($resultado);
        }
        else
        {
            throw new ErrorConferenciaInterna;
        }
    }
}