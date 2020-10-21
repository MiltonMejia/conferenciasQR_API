<?php

use const Conferencias\Config\credenciales;

class ResolveAsistente
{

    private $conexion;

    function __construct(){
        $this->conexion = new Conexion(credenciales);
    }

    public function obtenerTotalAsistentes()
    {
        $token = new Token();
        $token->verificarTokenAdministrativo();
        $cmdSQL = "SELECT id_asistente, folio_asistente, nombre_asistente, apellido_paterno, apellido_materno, correo, telefono, facebook, estados.nombre_estado, tipo_asistentes.nombre FROM asistentes INNER JOIN estados ON asistentes.id_estado = estados.id_estado INNER JOIN tipo_asistentes ON asistentes.id_tipoAsistente = tipo_asistentes.id_tipoAsistente ORDER BY id_asistente";
        $tabla = $this->conexion->obtenerResultados($cmdSQL);
        $conferencias = new ResolveConferencia();

        foreach($tabla as $fila)
        {
            $resultado[] =
            [
                'id' => $fila['id_asistente'],
                'folio' => $fila['folio_asistente'],
                'nombre' => $fila['nombre_asistente'],
                'apellidoPaterno' => $fila['apellido_paterno'],
                'apellidoMaterno' => $fila['apellido_materno'],
                'estado' => $fila['nombre_estado'],
                'correo' => $fila['correo'],
                'telefono' => $fila['telefono'],
                'facebook' => $fila['facebook'],
                'tipoAsistente' => $fila['nombre'],
                'conferencias' => $conferencias->obtenerTotalConferenciasAsistente($fila['id_asistente'],true)
            ];
        }
        return $resultado;
    }

    public function obtenerAsistente($idAsistente, $existeToken)
    {
        if($existeToken)
        {
            $token = new Token();
            $token->verificarTokenAdministrativo();
        }
        $cmdSQL = "SELECT id_asistente, folio_asistente, nombre_asistente, apellido_paterno, apellido_materno, correo, telefono, facebook, estados.nombre_estado, tipo_asistentes.nombre FROM asistentes INNER JOIN estados ON asistentes.id_estado = estados.id_estado INNER JOIN tipo_asistentes ON asistentes.id_tipoAsistente = tipo_asistentes.id_tipoAsistente WHERE id_asistente = ?";
        $param = ['s', [$idAsistente]];
        $tabla = $this->conexion->obtenerResultados_bindParam($cmdSQL, $param);
        $conferencias = new ResolveConferencia();

        foreach($tabla as $fila)
        {
            return
            [
                'id' => $fila['id_asistente'],
                'folio' => $fila['folio_asistente'],
                'nombre' => $fila['nombre_asistente'],
                'apellidoPaterno' => $fila['apellido_paterno'],
                'apellidoMaterno' => $fila['apellido_materno'],
                'estado' => $fila['nombre_estado'],
                'correo' => $fila['correo'],
                'telefono' => $fila['telefono'],
                'facebook' => $fila['facebook'],
                'tipoAsistente' => $fila['nombre'],
                'conferencias' => $conferencias->obtenerTotalConferenciasAsistente($fila['id_asistente'],false)
            ];
        }
    }

    public function obtenerAsistenteBusqueda($nombre, $apellidoPaterno, $apellidoMaterno)
    {
        $token = new Token();
        $token->verificarTokenAdministrativo();
        $cmdSQL = "SELECT id_asistente, folio_asistente, nombre_asistente, apellido_paterno, apellido_materno, correo, telefono, facebook, estados.nombre_estado, tipo_asistentes.nombre FROM asistentes INNER JOIN estados ON asistentes.id_estado = estados.id_estado INNER JOIN tipo_asistentes ON asistentes.id_tipoAsistente = tipo_asistentes.id_tipoAsistente WHERE nombre_asistente = ? AND apellido_paterno = ? AND apellido_materno = ?";
        $param = ['sss', [$nombre, $apellidoPaterno, $apellidoMaterno]];
        $tabla = $this->conexion->obtenerResultados_bindParam($cmdSQL, $param);
        $conferencias = new ResolveConferencia();

        foreach($tabla as $fila)
        {
            return
            [
                'id' => $fila['id_asistente'],
                'folio' => $fila['folio_asistente'],
                'nombre' => $fila['nombre_asistente'],
                'apellidoPaterno' => $fila['apellido_paterno'],
                'apellidoMaterno' => $fila['apellido_materno'],
                'estado' => $fila['nombre_estado'],
                'correo' => $fila['correo'],
                'telefono' => $fila['telefono'],
                'facebook' => $fila['facebook'],
                'tipoAsistente' => $fila['nombre'],
                'conferencias' => $conferencias->obtenerTotalConferenciasAsistente($fila['id_asistente'],true)
            ];
        }
    }

    public function insertarAsistente($datosAsistente)
    {

        $cmdSQL = "SELECT folio_asistente, id_tipoAsistente FROM asistentes WHERE folio_asistente = ? AND id_tipoAsistente = ?";
        $param = ['si',[$datosAsistente['folio'], $datosAsistente['tipoAsistente']]];
        $resultado = $this->conexion->obtenerResultados_bindParam($cmdSQL, $param);

        if(mysqli_num_rows($resultado) == 0)
        {
            $cmdSQL = "INSERT INTO asistentes(folio_asistente, nombre_asistente, apellido_paterno, apellido_materno, id_estado, correo, telefono, facebook, id_tipoAsistente) VALUES(?,?,?,?,?,?,?,?,?)";
            $param = ['ssssisssi',[
                $datosAsistente['folio'],
                $datosAsistente['nombre'],
                $datosAsistente['apellidoPaterno'],
                $datosAsistente['apellidoMaterno'],
                $datosAsistente['estado'],
                $datosAsistente['correo'],
                $datosAsistente['telefono'],
                $datosAsistente['facebook'],
                $datosAsistente['tipoAsistente']
                ]
            ];
            $resultado = $this->conexion->insertarDatos($cmdSQL, $param);
            if($resultado != false)
            {
                $datos = $this->obtenerAsistente($resultado, false);
                $token = new Token();
                $token->generarTokenUsuario($datos);
                return $datos;
            }
            else
            {
                throw new ErrorAsistenteInterno;
            }
        }
        else
        {
            throw new ErrorAsistenteDuplicado;
        }
    }

    public function insertarRegistroAsistencia($datosConferencia)
    {
        $token = new Token();
        $token->verificarTokenAdministrativo();
        $token->verificarTokenUsuario();
        $cmdSQL = "SELECT * FROM conferencias_asistentes WHERE id_asistente = ? AND id_conferencia = ?";
        $param = ['si',[$datosConferencia['asistente'], $datosConferencia['conferencia']]];
        $resultado = $this->conexion->obtenerResultados_bindParam($cmdSQL, $param);

        if(mysqli_num_rows($resultado) == 0)
        {
            $cmdSQL = "INSERT INTO conferencias_asistentes(id_asistente,id_conferencia) VALUES(?,?)";
            $resultado = $this->conexion->insertarDatos($cmdSQL, $param);
            if($resultado != false)
            {
                $conferencias = new ResolveConferencia();
                return $conferencias->obtenerConferenciaAsistente($resultado);
            }
            else
            {
                throw new ErrorAsistenciaInterna;
            }
        }
        else
        {
            throw new ErrorAsistenciaDuplicado;
        }
    }
    
}