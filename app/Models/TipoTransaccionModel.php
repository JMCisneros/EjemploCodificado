<?php namespace App\Models;

use CodeIgniter\Model;

class TipoTransaccionModel extends Model
{
    protected $table              ='tipotransaccion';
    protected $primaryKey         = 'id';

    protected $returnType         = 'array';
    protected $allowedFields       = ['descipcion'];

    protected $useTimestamps      = true;
    protected $createdField       ='created_at';
    protected $updatedField       ='updated_at';

    protected $validationRules    = [
        'descripcion'     => 'required|alpha_space|min_length[3]|max_length[75]',
    ];

    protected $skipValidation = false;
}