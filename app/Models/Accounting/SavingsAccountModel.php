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
        'balance',
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
        $totals = $db->table('savings_accounts')
            ->select('balance as total_savings')
            ->where('member_id', $memberId)
            ->get()
            ->getRow();

        return (float) $totals->total_savings;
    }

    // get total savings for all members
    public function getTotalSavings()
    {
        $db = \Config\Database::connect();

        // Step 3: Sum DEBITS only to the member’s savings account
        $totals = $db->table('savings_accounts')
            ->selectSum('balance', 'total_savings')
            ->get()
            ->getRow();

        return (float) $totals->total_savings;
    }
}
