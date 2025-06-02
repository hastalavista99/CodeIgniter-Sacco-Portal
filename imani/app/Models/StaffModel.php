<?php

namespace App\Models;

use CodeIgniter\Model;

class StaffModel extends Model
{
    protected $table            = 'staff';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'staff_number',
        'first_name',
        'last_name',
        'email',
        'phone',
        'gender',
        'position',
        'department',
        'hire_date',
        'photo',
        'status',
        'user_id',
    ];

    protected $useTimestamps = true;

    // get active staff members
    public function getActiveStaffMembers()
    {
        $db = \Config\Database::connect();
        
        // Fetch active staff members
        $activeStaff = $db->table($this->table)
            ->where('status', 'active')
            ->countAllResults();
        
        return $activeStaff;
    }

}
