<?php namespace App\Filters;

use App\Models\$RolModel;
use CodeIgniter\Filters\FiltersInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Firebase\JWT\JWT;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\ExpiredException;

class AuthFilters implemeents FiltersInterface{

    use ResponseTrait;

    public function before(RequestInterface $request, $arguments = null){

        //se ejetuca antes que el controlador
        try{
            $key = Services::geSecretKey();
            $authHeader = $request -> getServe('HTTP_AUTHORIZATION');

            if($authHeader == null){
                return Services::response()->setStatusCode(RequestInterface::HTTP_ANAUTHORIZED, 'No se ah enviado el JWT requerido');
               
                $arr = explode(' ',$authHeader);
                $jwt = $arr[1];

                JWT::decode($jwt,$key,['HS256']);

                $rolModel = new $rolModel();
                $rol => $rolModel -> find($jwt -> data -> rol);

                if ($rol ==null) {
                    return Services::response()->setStatusCode(RequestInterface::HTTP_ANAUTHORIZED, 'El rol del JWT es invalido');
                    return true;
                }
            }catch(ExpiredException $e){
                return Services::response()->setStatusCode(RequestInterface::HTTP_ANAUTHORIZED, 'Su token JWT ha expirado');
            }
        }catch(){
            return Services::response()->setStatusCode(RequestInterface::HTTP_INTERNAL_SERVER_ERROR, 'Ocurrio un error en el servidor al validar el token');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null){
        
    }

}

    
