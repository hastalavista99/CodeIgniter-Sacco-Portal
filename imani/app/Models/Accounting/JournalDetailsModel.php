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

    public function getMemberTransactionDetails($memberId)
    {
        return $this->db->table('journal_entry_details')
            ->select('journal_entry_details.*, accounts.account_name, journal_entries.description, journal_entries.created_at')
            ->join('accounts', 'accounts.id = journal_entry_details.account_id')
            ->join('journal_entries', 'journal_entries.id = journal_entry_details.journal_entry_id')
            ->join('savings_accounts', 'savings_accounts.account_id = journal_entry_details.account_id', 'left')
            ->join('share_accounts', 'share_accounts.account_id = journal_entry_details.account_id', 'left')
            ->where('savings_accounts.member_id', $memberId)
            ->orWhere('share_accounts.member_id', $memberId)
            ->orderBy('journal_entries.created_at', 'DESC')
            ->get()->getResultArray();
    }

    public function getAllTransactions($memberNumber)
    {
        return $this->db->table('transactions')
            ->where('member_number', $memberNumber)
            ->get()->getResultArray();
    }

    public function getCashbookEntries($startDate, $endDate, $accountId = null)
    {
        $builder = $this->db->table($this->table)
            ->select('
                journal_entries.date,
                journal_entries.description,
                journal_entries.reference,
                journal_entry_details.debit,
                journal_entry_details.credit
            ')
            ->join('journal_entries', 'journal_entries.id = journal_entry_details.journal_entry_id')
            ->where('journal_entries.date >=', $startDate)
            ->where('journal_entries.date <=', $endDate);

        if ($accountId) {
            $builder->where('journal_entry_details.account_id', $accountId);
        } else {
            // Include all asset (cash/bank) accounts
            $builder->join('accounts', 'accounts.id = journal_entry_details.account_id');
            $builder->where('accounts.category', 'asset');
        }

        $builder->orderBy('journal_entries.date', 'asc');

        return $builder->get()->getResultArray();
    }
}
