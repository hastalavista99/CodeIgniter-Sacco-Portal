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


    public function getMemberSharesTotal($memberId)
    {
        $db = \Config\Database::connect();
    
        // Get the member's shares account_id
        $sharesAccount = $db->table('share_accounts')
            ->select('account_id')
            ->where('member_id', $memberId)
            ->get()
            ->getRow();
    
        if (!$sharesAccount) {
            return 0;
        }
    
        // Sum credits and debits
        $query = $db->table('journal_entry_details')
            ->select('SUM(credit) as total_credit, SUM(debit) as total_debit')
            ->where('account_id', $sharesAccount->account_id)
            ->get()
            ->getRow();
    
        return ($query->total_credit - $query->total_debit);
    }
    
}
