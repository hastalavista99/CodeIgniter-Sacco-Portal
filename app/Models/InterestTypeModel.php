<?php

namespace App\Models;

use CodeIgniter\Model;

class InterestTypeModel extends Model
{
    protected $table = 'interest_types';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name',
        'description'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
