<?php

namespace App\Models\Accounting;

use CodeIgniter\Model;

class JournalDetailsModel extends Model
{
    protected $table = 'journal_entry_details';
    protected $primaryKey = 'id';
    protected $allowedFields = ['journal_entry_id', 'account_id', 'debit', 'credit', 'transaction_id'];

    public function getTotalByType($type, $year)
    {
        return $this->selectSum('credit - debit', 'total')
            ->join('accounts', 'accounts.id = journal_entry_details.account_id')
            ->where('accounts.type', $type)
            ->where("YEAR(journal_entry_details.created_at)", $year)
            ->get()
            ->getRow()
            ->total ?? 0;
    }

    public function createClosingEntry($year, $netProfit)
    {
        $db = \Config\Database::connect();
        $accountModel = new \App\Models\Accounting\AccountsModel();

        // Get Retained Earnings Account
        $retainedEarnings = $accountModel->where('type', 'equity')->where('name', 'Retained Earnings')->first();

        if (!$retainedEarnings) {
            throw new \Exception("Retained Earnings account not found!");
        }

        $this->insert([
            'account_id' => $retainedEarnings['id'],
            'debit' => ($netProfit < 0) ? abs($netProfit) : 0,
            'credit' => ($netProfit > 0) ? $netProfit : 0,
            'description' => "Closing entry for $year",
            'date' => "$year-12-31"
        ]);
    }
}
