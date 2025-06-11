<?php

namespace App\Models;

use CodeIgniter\Model;

class ExcelModel extends Model {
    protected $table = 'balances'; // Change to your table name
    protected $allowedFields    = ['member_no', 'shares', 'deposits', 'loan']; // Add column names here

    public function insert_data($data) {
        $this->insert($data);
    }
}
