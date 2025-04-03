<?php
namespace App\Models\Accounting;

use CodeIgniter\Model;

class TransactionsModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $allowedFields = [ 'member_number', 'service_transaction', 'transaction_type', 
    'amount', 'payment_method', 'transaction_date', 'description'
    ];


    
}