<?php

namespace App\Models;

use CodeIgniter\Model;

class RefreshTokenModel extends Model
{
    protected $table = 'refresh_tokens';
    protected $primaryKey = 'id';
    protected $allowedFields = ['member_no', 'token', 'expires_at', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
