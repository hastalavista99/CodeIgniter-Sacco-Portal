<?php

namespace App\Models\Accounting;

use CodeIgniter\Model;

class SharesAccountModel extends Model
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
