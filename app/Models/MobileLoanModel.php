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
}