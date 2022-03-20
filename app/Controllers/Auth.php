<?php namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\UsuarioModel;
use Config\Services;
use Firebase\JWT\JWT;

class Auth extends BaseController
{
    use ResponseTrait;

    public function __construct(){
        helper('secure_password');
    }

    public function login()
    {
       try {
           $username = $this -> request -> getPost('username');
           $password = $this -> request -> getPost('password');

            $usuarioModel = new UsuarioModel();
            $validateUsuario = $usuarioModel -> where('username', $username) -> first();

            if($validateUsuario == null)
                return $this -> failNotFound('Usuario no encontrado');

            if (verifyPassword($password,$validateUsuario["password"])):
                $jwt = $this -> generateJWT($validateUsuario);
                return $this -> respond(['Token' => $jwt], 201);

             else:
                return $this -> failValidationError ('Contraseña invalida');
             endif;
        }catch(\Exception $e){
            return $this -> failServerError('Ha ocurrido un error en el servidor');
        }
    }

    protected function generteJWT($usuario){
        $key = Services::geSecretKey();
        $time = time();
        $payload =[
            'aud' => base_url(),
            'iat' => $time,
            'exp' => $time + 120,
            'data' => [
                'nombre' => $usuario['nombre'],
                'username' =>  $usuario['username'],
                'rol' => $usuario['rol_id']
            ]
        ];


        $jwt = JWT::encode($payload,$key);
        return $jwt;
    }
}