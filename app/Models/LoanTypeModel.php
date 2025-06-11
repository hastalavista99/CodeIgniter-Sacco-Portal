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

    public function getLoanTypes()
    {
        return $this->select('
            loan_types.*,
            interest_types.name AS interest_method
        ')
            ->join('interest_types', 'interest_types.id = loan_types.interest_type_id')
            ->orderBy('loan_types.id', 'DESC')
            ->findAll();
    }

    public function getLoanType($id)
    {
        return $this->select('
            loan_types.*,
            interest_types.name AS interest_method,
            accounts.account_code AS account_code
        ')
            ->join('interest_types', 'interest_types.id = loan_types.interest_type_id')
            ->join('accounts','accounts.account_name = loan_types.loan_name')
            ->where('loan_types.id', $id)
            ->first();
    }
}
