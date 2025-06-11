<?php

namespace App\Models;

use CodeIgniter\Model;

class BeneficiaryModel extends Model
{
    protected $table = 'beneficiaries';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'member_id',
        'first_name',
        'last_name',
        'dob',
        'phone_number',
        'relationship',
        'is_beneficiary',
        'entitlement_percentage'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'member_id' => 'required|integer'
    ];

    // app/Models/BeneficiariesModel.php

    public function getByMemberId($memberId)
    {
        return $this->where('member_id', $memberId)
            ->where('is_beneficiary', 1)
            ->findAll();
    }
}
