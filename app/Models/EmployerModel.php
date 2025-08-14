<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployerModel extends Model
{
    protected $table            = 'employers';
    protected $primaryKey       = 'employer_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'employer_name',
        'contact_person',
        'phone_number',
        'email',
        'postal_address',
        'physical_address',
        'checkoff_code',
        'deduction_frequency',
        'status'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get all active employers
     */
    public function getActiveEmployers()
    {
        return $this->where('status', 'Active')->findAll();
    }
}
