<?php
namespace App\Models\Accounting;

use CodeIgniter\Model;

class AccountsModel extends Model
{
    protected $table = 'accounts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['account_name', 'account_code', 'category'];
}
