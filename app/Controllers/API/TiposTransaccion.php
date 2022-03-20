<?php namespace App\Controllers\API;

use App\Models\TipoTransaccionModel;
use CodeIgniter\RESTful\ResourceController;

class TiposTransaccion extends ResourceController
{
    public function __construct(){
        $this -> model = $this->setModel(new TipoTransaccionModel());
    }

    public function index()
    {
        $tipostransacciones = $this->model->findAll();
        return $this->respond($tipostransacciones);
    }

    public function create(){

        try{
            $tipotransaccion = $this -> request -> getJSON();
            if($this->model->insert($tipotransaccion)){
                $tipotransaccion ->id = $this->model->insertID();
                return $this ->respondCreated($tipotransaccion);
            }else{
                return $this -> failValidationError($this->model->validation->listErrors());
            }
        }catch(\Exception $e){
            return $this -> failServerError('Ha ocurrido un error en el servidor');
        }

    }

    public function edit($id = null)
    {

         try{

            if($id == null)
                return $this->failValidationError('No se ha pasado un Id valido');

            $tipotransaccion = $this -> model -> find($id);

            if($tipotransaccion == null)
                return $this -> failNotFound('No se ha encontrado un cliente con el id: '. $id);

            return $this -> respond($tipotransaccion);    

        }catch(\Exception $e){
            return $this -> failServerError('Ha ocurrido un error en el servidor');
        }
    }

    public function update($id = null)
    {

         try{

            if($id == null)
                return $this->failValidationError('No se ha pasado un Id valido');

            $tipotransaccionVerificado = $this -> model -> find($id);

            if($tipotransaccionVerificado == null)
                return $this -> failNotFound('No se ha encontrado un cliente con el id: '. $id);

            $tipotransaccion = $this -> request->getJSON();

            if($this->model->update($id, $tipotransaccion)){
                $tipotransaccion -> id = $id;
                return $this ->respondUpdated($tipotransaccion);
            }else{
                return $this -> failValidationError($this->model->validation->listErrors());
            }

        }catch(\Exception $e){
            return $this -> failServerError('Ha ocurrido un error en el servidor');
        }
    }

    public function delete($id = null)
    {
        try{

            if($id == null)
                return $this->failValidationError('No se ha pasado un Id valido');

            $tipotransaccionVerificado = $this -> model -> find($id);

            if($tipotransaccionVerificado == null)
                return $this -> failNotFound('No se ha encontrado un cliente con el id: '. $id);

            if($this->model->delete($id)){
                return $this ->respondDeleted($tipotransaccionVerificado);
            }else{
                return $this -> failServerError('No se ha podido eliminar el registro');
            }

        }catch(\Exception $e){
            return $this -> failServerError('Ha ocurrido un error en el servidor');
        }
    }

}