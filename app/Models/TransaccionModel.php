<?php namespace App\Models;

use CodeIgniter\Model;

class TransaccionModel extends Model
{
    protected $table              ='transaccion';
    protected $primaryKey         = 'id';

    protected $returnType         = 'array';
    protected $allowedFields       = ['cuenta_id', 'tipo_transaccion_id', 'monto'];

    protected $useTimestamps      = true;
    protected $createdField       ='created_at';
    protected $updatedField       ='updated_at';

    protected $validationRules    = [
        'monto'     => 'required|numeric',
        'cuenta_id'   => 'required|integer|is_valid_cuenta',
        'tipo_transaccion_id'   => 'required|integer|is_valid__tipo_transaccion',
    ];

    protected $validationMessages = [
        'cuenta_id'     => [
            'is_valid_cuenta' => 'Estimado Usuario, debe ingresar una cuenta valida'
        ],

        'tipo_transaccion_id'  => [
            'is_valid__tipo_transaccion' => 'Estimado Usuario, debe ingresar un tipo transaccion valido'
        ]
    ];

    protected $skipValidation = false;

    public function TransaccionesPorCliente($clienteId =null){
        
        $builder = $this -> db -> table($this -> table); 
        $builder -> select('cuenta.id AS NumeroCuenta, cliente.nombre, cliente.apellido');
        $builder -> select('tipo_transaccion.descripcion AS Tipo, transaccion.monto, transaccion.created_at AS FechaTransaccion');
        $builder -> join('cuenta', 'transaccion_cuenta_id = cuenta.id');
        $builder -> join('tipo_transaccion', 'transaccion.tipo_transaccion = tipo_transaccion.id');
        $builder -> join('cliente', 'cuenta_cliente_id = cliente.id');
        $builder -> where('cliente_id', $clienteId);

        $query = $builder -> get();
        return $query -> getResult();
    }
}