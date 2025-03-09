<?php
namespace App\Models\Accounting;

use CodeIgniter\Model;

class JournalEntryModel extends Model
{
    protected $table = 'journal_entries';
    protected $primaryKey = 'id';
    protected $allowedFields = ['date', 'description', 'reference','created_by', 'posted'];
}
