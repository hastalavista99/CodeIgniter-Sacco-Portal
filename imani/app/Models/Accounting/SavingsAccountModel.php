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

    /**
     * Get total savings for a member.
     */
    public function getMemberSavingsTotal($memberId)
    {
        $db = \Config\Database::connect();

        // Step 1: Get member number
        $member = $db->table('members')
            ->select('member_number')
            ->where('id', $memberId)
            ->get()
            ->getRow();

        if (!$member) {
            return 0;
        }


        // Step 3: Sum DEBITS only to the member’s savings account
        $totals = $db->table('transactions')
            ->select('SUM(amount) as total_savings')
            ->where('member_number', $member->member_number)
            ->where('service_transaction', 'savings')
            ->get()
            ->getRow();

        return (float) $totals->total_savings;
    }
}
