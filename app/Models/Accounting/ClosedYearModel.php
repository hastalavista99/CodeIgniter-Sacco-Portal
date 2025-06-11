<?php

namespace App\Accounting\Models;

use CodeIgniter\Model;

class ClosedYearModel extends Model
{
    protected $table = 'closed_years';
    protected $allowedFields = ['year', 'closed_by', 'closed_at'];
}
