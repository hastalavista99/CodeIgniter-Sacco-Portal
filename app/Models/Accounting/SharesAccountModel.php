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
        $totals = $db->table('share_accounts')
            ->select('shares_owned as total_shares')
            ->where('member_id', $memberId)
            ->get()
            ->getRow();
    
        return ($totals->total_shares);
    }
    
    // get total shares for all members
    public function getTotalShares()
    {
        $db = \Config\Database::connect();
    
        // Sum shares for all members
        $totals = $db->table('share_accounts')
            ->selectSum('shares_owned', 'total_shares')
            ->get()
            ->getRow();
    
        return ($totals->total_shares);
    }
}
