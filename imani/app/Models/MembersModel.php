<?php

namespace App\Models;

use CodeIgniter\Model;

class MembersModel extends Model
{
    protected $table = 'members';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    
    protected $allowedFields = [
        'member_number',
        'first_name', 'last_name', 'dob', 'join_date', 'gender', 
        'nationality', 'marital_status', 'id_number', 'terms_accepted',
        'email', 'phone_number', 'alternate_phone', 'street_address', 
        'address_line2', 'city', 'county', 'zip_code', 'photo_path'
    ];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $validationRules = [
        'member_number' => 'required|min_length[2]|max_length[100]',
        'first_name'    => 'required|min_length[2]|max_length[100]',
        'last_name'     => 'required|min_length[2]|max_length[100]',
        'dob'           => 'required|valid_date',
        'join_date'     => 'required|valid_date',
        'gender'        => 'required',
        'nationality'   => 'required',
        'email'         => 'required|valid_email|is_unique[members.email,id,{id}]',
        'phone_number'  => 'required',
        'street_address'=> 'required',
        'city'          => 'required',
        'county'        => 'required',
        'zip_code'      => 'required',
        'terms_accepted'=> 'required'
    ];
    
    protected $validationMessages = [
        'email' => [
            'is_unique' => 'This email is already registered in our system.'
        ]
    ];
    
    public function insertMemberWithBeneficiary($memberData, $beneficiaryData)
    {
        $db = \Config\Database::connect();
        $db->transStart();
        
        // Insert member data
        $this->insert($memberData);
        $memberId = $this->getInsertID();
        
        // Add member_id to beneficiary data
        $beneficiaryData['member_id'] = $memberId;
        
        // Insert beneficiary data if it exists
        $beneficiaryModel = new \App\Models\BeneficiaryModel();
        $beneficiaryModel->insert($beneficiaryData);
        
        $db->transComplete();
        
        return ($db->transStatus() === false) ? false : $memberId;
    }
}