<?php
namespace App\Models\Accounting;

use CodeIgniter\Model;

class JournalDetailsModel extends Model
{
    protected $table = 'journal_entry_details';
    protected $primaryKey = 'id';
    protected $allowedFields = ['journal_entry_id', 'account_id', 'debit', 'credit'];
}
