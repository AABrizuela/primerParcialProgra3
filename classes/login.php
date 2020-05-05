<?php

require_once "./vendor/autoload.php";
use \Firebase\JWT\JWT;

class Auth
{
    public static function login($email,$clave,$key){
        $rta = Io::LeerCosas('data/users.txt');        
        $retorno = false;
        if($rta) {
            foreach ($rta as $cliente) {
                if($cliente->email == $email && $cliente->clave == $clave){
                    $payload = array (                        
                        "email" => $cliente->email,                        
                        "clave" => $cliente->clave,                        
                    );
                    $retorno = true;
                    break;
                }
            }
            if($retorno) {
                $retorno = JWT::encode($payload,$key);
            }
        }
        return $retorno;
    }

    public static function decodeJWT($key, $header)
    {
        //obtengo todos los headers
        $headers = getallheaders();

        //busco el token que necesito en el array de headers
        $token = $headers[$header];

        try {
            $jwt = JWT::decode($token, $key, array("HS256"));

            return $jwt;
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
}

?>