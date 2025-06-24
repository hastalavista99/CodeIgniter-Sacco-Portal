<?php
namespace App\Models;

use CodeIgniter\Model;

class MemberBeneficiariesModel extends Model
{
    protected $table = 'member_beneficiaries';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'registration_id', 'first_name', 'last_name', 'dob', 'id_number', 'relationship', 'entitlement_percentage'
    ];
    public $timestamps = false;
}
