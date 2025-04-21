<?php

namespace App\Models;

use CodeIgniter\Model;

class SystemParameterModel extends Model
{
    protected $table            = 'system_parameters';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'param_key', 
        'param_value', 
        'description'
    ];
    protected $returnType       = 'array';
    public    $useTimestamps    = false;
}
