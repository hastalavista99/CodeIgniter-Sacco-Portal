<?php

namespace App\Models;

use CodeIgniter\Model;

class LoanGuarantorModel extends Model
{
    protected $table = 'loan_guarantors';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'loan_application_id', 'guarantor_member_no', 'name', 'mobile', 'amount'
    ];
}
