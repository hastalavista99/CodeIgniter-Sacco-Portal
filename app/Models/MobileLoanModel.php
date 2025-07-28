<?php

namespace App\Models;

use CodeIgniter\Model;

class MobileLoanModel extends Model
{
    protected $table = 'mobile_loans';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $returnType = 'array'; // Or 'object' if preferred
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'member_id',
        'amount_requested',
        'amount_approved',
        'interest_rate',
        'tenure_days',
        'purpose',
        'status',
        'application_date',
        'approval_date',
        'disbursed_at',
        'due_date',
        'repaid_at',
        'repayment_method',
        'mobile_transaction_id',
        'remarks',
        'verified_by',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Optional validation rules
    protected $validationRules = [
        'member_id'        => 'required|is_natural_no_zero',
        'amount_requested' => 'required|decimal|greater_than[0]',
        'tenure_days'      => 'required|integer|greater_than[0]',
        'purpose'          => 'permit_empty|string|max_length[255]',
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;
}
