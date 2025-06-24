<?php
namespace App\Models;

use CodeIgniter\Model;

class MembersRegistrationModel extends Model
{
    protected $table = 'members_registration';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'first_name', 'last_name', 'dob', 'id_number', 'physical_address', 'postal_address',
        'email', 'phone_number', 'area_chief', 'next_of_kin_name', 'next_of_kin_relationship',
        'next_of_kin_address', 'next_of_kin_phone', 'next_of_kin_email', 'employer', 'personal_number',
        'date_of_appointment', 'working_station', 'employer_email', 'employment_type',
        'monthly_contribution', 'remittance_mode', 'employer_authorization', 'business_name',
        'business_postal_address', 'business_postal_code', 'business_nature', 'business_physical_location',
        'mobile_banking', 'passport_photo'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
}
