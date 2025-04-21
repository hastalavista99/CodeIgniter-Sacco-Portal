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

        // Get the member's savings account_id
        $savingsAccount = $db->table('savings_accounts')
            ->select('account_id')
            ->where('member_id', $memberId)
            ->get()
            ->getRow();

        if (!$savingsAccount) {
            return 0; // No savings account for this member
        }

        // Sum all credits and debits from journal entries
        $query = $db->table('journal_entry_details')
            ->select('SUM(credit) as total_credit, SUM(debit) as total_debit')
            ->where('account_id', $savingsAccount->account_id)
            ->get()
            ->getRow();

        return ($query->total_credit - $query->total_debit);
    }
}
