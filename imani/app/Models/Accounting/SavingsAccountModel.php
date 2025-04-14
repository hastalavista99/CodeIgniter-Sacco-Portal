<?php
namespace App\Models\Accounting;

use CodeIgniter\Model;

class SavingsAccountModel extends Model
{
    protected $table = 'savings_accounts';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'member_id',
        'account_id',
        'account_number',
        'account_type',
        'created_at',
        'updated_at',
    ];
}
