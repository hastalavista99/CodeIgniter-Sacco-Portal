<?php

namespace App\Models\Accounting;

use CodeIgniter\Model;

class AccountsModel extends Model
{
    protected $table = 'accounts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['account_name', 'account_code', 'category', 'parent_id', 'member_id'];

    public function getCashAccounts()
    {
        return $this->where('category', 'asset')->findAll();
    }
}
