<?php
namespace Modules\Accounting\Models;

use CodeIgniter\Model;

class JournalEntryModel extends Model
{
    protected $table = 'journal_entries';
    protected $primaryKey = 'id';
    protected $allowedFields = ['date', 'description', 'reference', 'posted'];
}
