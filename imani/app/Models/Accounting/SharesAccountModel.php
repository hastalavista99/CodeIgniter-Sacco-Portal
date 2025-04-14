<?php

namespace App\Models;

use CodeIgniter\Model;

class ShareAccountModel extends Model
{
    protected $table = 'share_accounts';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'member_id',
        'account_id',
        'shares_owned',
        'created_at',
        'updated_at',
    ];
}
