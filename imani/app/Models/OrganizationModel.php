<?php
namespace App\Models;

use CodeIgniter\Model;

class OrganizationModel extends Model
{
    protected $table            = 'organization_profile';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'org_name', 
        'phone', 
        'email', 
        'postal_address', 
        'physical_address', 
        'logo'
    ];
    protected $returnType       = 'array';
    public    $useTimestamps    = false; // Only updated_at is managed manually
}


