<?php

namespace App\Models;

use CodeIgniter\Model;

class MobileLoanModel extends Model
{
    protected $table = 'mobile_loans';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'member_id',
        'amount',
        'interest_rate',
        'total_repayable',
        'repayment_due_date',
        'disbursement_status',
        'mpesa_receipt',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // create a function to get the member details per loan, take the member_number, first_name and last_name, join this with the mobile loans table
    public function getMemberDetailsPerLoan()
    {
        return $this->select('mobile_loans.*, members.member_number, members.first_name, members.last_name')
            ->join('members', 'members.id = mobile_loans.member_id')
            ->findAll();
    }
}