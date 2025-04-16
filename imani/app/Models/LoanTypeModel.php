<?php

namespace App\Models;

use CodeIgniter\Model;

class LoanTypeModel extends Model
{
    protected $table = 'loan_types';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'loan_name',
        'service_charge',
        'interest_type_id',
        'interest_rate',
        'insurance_premium',
        'crb_amount',
        'min_repayment_period',
        'max_repayment_period',
        'min_loan_limit',
        'max_loan_limit',
        'description'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
