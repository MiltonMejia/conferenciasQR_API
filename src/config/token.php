<?php
use \Firebase\JWT\JWT;
use const \Conferencias\Config\tokenKey;
use const \Conferencias\Config\jtiKeyUsuario;
use const \Conferencias\Config\jtiKeyAdministrativo;

class Token{

    private $iss;
    private $aud;
    private $iat;
    private $token;

    function __construct() {
        $this->iss = "";
        $this->aud = "web";
        $this->iat = strtotime("now");
        $this->token = new ArrayObject();
    }

    public function generarTokenUsuario($datos){
        $this->token['iss'] = $this->iss;
        $this->token['aud'] = $this->aud;
        $this->token['iat'] = $this->iat;
        $this->token['exp'] = strtotime("6 month");
        $this->token['id'] = $datos['id'];
        $this->token['fol'] = $datos['folio'];
        $this->token['name'] = $datos['nombre'];
        $this->token['apat'] = $datos['apellidoPaterno'];
        $this->token['amat'] = $datos['apellidoMaterno'];
        $this->token['tip'] = $datos['tipoAsistente'];
        $this->token['jti'] = sha1(strtoupper($datos['id'].$datos['folio'].$datos['tipoAsistente'].jtiKeyUsuario));
        $jwt = JWT::encode($this->token,tokenKey);
        header('Token:'.$jwt.'');
    }

    public function generarTokenAdministrativo($usuario, $contrasena, $privilegio){
        $this->token['iss'] = $this->iss;
        $this->token['aud'] = $this->aud;
        $this->token['iat'] = $this->iat;  
        $this->token['exp'] = strtotime("1 day");
        $this->token['user'] = $usuario;
        $this->token['priv'] = $privilegio;
        $this->token['jti'] = sha1(strtoupper($this->token.$usuario.jtiKeyAdministrativo.$contrasena.$privilegio));
        $jwt = JWT::encode($this->token,tokenKey);
        header('Token:'.$jwt.'');
    }

    public function verificarTokenUsuario(){

        $header = getallheaders();
        $token = $header['Token'];

        try
        {
            $datosToken = JWT::decode($token, tokenKey, array('HS256'));
            $asistente = new ResolveAsistente();
            $datosAsistente = $asistente->obtenerAsistente($datosToken->id, false);
            if($datosToken->iss != $this->iss || $datosToken->jti != sha1(strtoupper($datosAsistente['id'].$datosAsistente['folio'].$datosAsistente['tipoAsistente'].jtiKeyUsuario))) {
                throw new ErrorTokenInvalido;
            }
        }
        catch(ExpiredException $e)
        {
            throw new ErrorTokenExpirado;
        }
        catch(Exception $e)
        {
            throw new ErrorTokenInvalido;
        }

    }

    public function verificarTokenAdministrativo(){

        $header = getallheaders();
        $token = $header['Token'];

        try
        {
            $datosToken = JWT::decode($token, tokenKey, array('HS256'));
            $asistente = new ResolveAdministrativo();
            $datosAsistente = $asistente->obtenerAdministrativoToken($datosToken->user);
            if($datosToken->iss != $this->iss || $datosToken->jti != sha1(strtoupper($this->iss.$datosAsistente['usuario'].jtiKeyAdministrativo.$datosAsistente['contrasena'].$datosAsistente['privilegio']))) {
                throw new ErrorTokenInvalido;
            }
        }
        catch(ExpiredException $e)
        {
            throw new ErrorTokenExpirado;
        }
        catch(Exception $e)
        {
            throw new ErrorTokenInvalido;
        }
    }

}