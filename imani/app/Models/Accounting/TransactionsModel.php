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
        'description',
        'reference',
    ];


    public function getSavingsTransactions($memberNumber)
    {
        return $this->where('member_number', $memberNumber)->where('service_transaction', 'savings')->findAll();
    }

    public function getSharesTransactions($memberNumber)
    {
        return $this->where('member_number', $memberNumber)->where('service_transaction', 'share_deposits')->findAll();
    }

    public function getRecentTransactions($memberNumber, $limit = 5)
    {
        return $this->where('member_number', $memberNumber)
            ->orderBy('transaction_date', 'DESC')
            ->limit($limit)
            ->find();
    }

    public function getMonthlyTotal(string $type, string $yearMonth, ?string $memberNo = null): float
    {
        $builder = $this->selectSum('amount')
            ->where('service_transaction', $type)
            ->like('transaction_date', $yearMonth, 'after');

        if ($memberNo) {
            $builder->where('member_number', $memberNo);
        }

        $result = $builder->get()->getRow();

        return (float) ($result->amount ?? 0);
    }
}
