<?php

namespace App\Models\Accounting;

use CodeIgniter\Model;

class TransactionsModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'member_number',
        'service_transaction',
        'transaction_type',
        'amount',
        'payment_method',
        'transaction_date',
        'description'
    ];


    public function getSavingsTransactions($memberNumber)
    {
        return $this->where('member_number', $memberNumber)->where('service_transaction', 'savings')->findAll();
    }

    public function getSharesTransactions($memberNumber)
    {
        return $this->where('member_number', $memberNumber)->where('service_transaction', 'share_deposits')->findAll();
    }
}
