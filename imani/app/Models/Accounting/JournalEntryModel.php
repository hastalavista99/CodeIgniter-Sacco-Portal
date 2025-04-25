<?php
namespace App\Models\Accounting;

use CodeIgniter\Model;

class JournalEntryModel extends Model
{
    protected $table = 'journal_entries';
    protected $primaryKey = 'id';
    protected $allowedFields = ['date', 'description', 'reference','created_by', 'posted'];


    protected function getJournalDetails($id)
    {
        return $this->select('*');
    }

    public function getJournalsWithUser()
    {
        return $this->db->table('journal_entries')
        ->select('journal_entries.*, user.name')
        ->join('user', 'user.id = journal_entries.created_by')
        ->get()->getResultArray();
    }
}
