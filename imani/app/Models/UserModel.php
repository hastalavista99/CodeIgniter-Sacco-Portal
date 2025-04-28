<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $allowedFields = ['user', 'name', 'member_no','mobile', 'email', 'password', 'role', 'permissions', 'temp'];
    
}