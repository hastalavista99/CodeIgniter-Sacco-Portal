<?php

namespace App\Controllers\Accounting;

use App\Controllers\BaseController;
use App\Controllers\Loans;
use App\Controllers\LoanService;
use App\Models\Accounting\AccountsModel;
use App\Models\Accounting\JournalEntryModel;
use App\Models\Accounting\JournalDetailsModel;
use App\Models\Accounting\SavingsAccountModel;
use App\Models\Accounting\SharesAccountModel;
use App\Controllers\Accounting\JournalService;
use App\Models\Accounting\TransactionsModel;
use App\Models\LoanApplicationModel;
use App\Models\LoanTypeModel;
use App\Models\MembersModel;
use App\Models\UserModel;

class JournalController extends BaseController
{
    public function page()
    {
        helper('userpermissionhelper');
        require APPPATH . 'Helpers/userpermissionhelper.php';

        $model = new JournalEntryModel();
        $journals = $model->getJournalsWithUser();
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);
        // $isTrue= dd(function_exists('user_can')); // should return true


        $data = [
            'title' => 'Journal Entries',
            'entries' => $journals,
            'userInfo' => $userInfo,

        ];
        return view('accounting/journal_list', $data);
    }

    public function createPage()
    {
        helper('form');

        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $accountsModel = new AccountsModel;
        $accounts = $accountsModel->findAll();

        $data = [
            'title' => 'Create New Entry',
            'userInfo' => $userInfo,
            'accounts' => $accounts
        ];
        return view('accounting/journal_create', $data);
    }

    public function store()
    {
        $validationRules = [
            'transaction_date' => 'required|valid_date',
            'reference'        => 'required',
            'description'      => 'required',
            'accounts'         => 'required',
            'debit'            => 'required_without[credit]',
            'credit'           => 'required_without[debit]',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $journalEntryModel = new JournalEntryModel();
        $journalDetailModel = new JournalDetailsModel();
        $accountsModel =  new AccountsModel();
        $user = session()->get('loggedInUser');

        // Insert into journal_entries table
        $entryData = [
            'date'             => $this->request->getPost('transaction_date'),
            'description'      => $this->request->getPost('description'),
            'reference'        => $this->request->getPost('reference'),
            'created_by'       => $user,
        ];

        $entryId = $journalEntryModel->insert($entryData);

        // Insert into journal_details table
        $accounts = $this->request->getPost('accounts');
        $debits   = $this->request->getPost('debit');
        $credits  = $this->request->getPost('credit');

        $totalDebit = 0;
        $totalCredit = 0;

        foreach ($accounts as $index => $account) {
            $debit  = !empty($debits[$index]) ? floatval($debits[$index]) : 0;
            $credit = !empty($credits[$index]) ? floatval($credits[$index]) : 0;

            $totalDebit += $debit;
            $totalCredit += $credit;

            $journalDetailModel->insert([
                'journal_entry_id' => $entryId,
                'account_id'       => $account,
                'debit'            => $debit,
                'credit'           => $credit,
            ]);
        }

        // Ensure double-entry accounting is balanced
        if ($totalDebit !== $totalCredit) {
            return redirect()->back()->withInput()->with('error', 'Debits and Credits must be equal.');
        }

        return redirect()->to('accounting/journals/page')->with('success', 'Journal Entry Created Successfully');
    }

    public function post($id)
    {
        $journalEntryModel = new JournalEntryModel();

        // Check if the journal entry exists and is not already posted
        $entry = $journalEntryModel->find($id);
        if (!$entry) {
            return redirect()->back()->with('error', 'Journal Entry not found.');
        }

        if ($entry['posted']) {
            return redirect()->back()->with('error', 'Journal Entry is already posted.');
        }

        // Update the posted field
        $journalEntryModel->update($id, ['posted' => 1]);

        return redirect()->to('accounting/journals/page')->with('success', 'Journal Entry posted successfully.');
    }

    public function view($id = null)
    {
        helper('form');

        $entryModel = new JournalEntryModel();
        $detailsModel = new JournalDetailsModel();
        $accountModel = new AccountsModel();
        $entry = $entryModel->find($id);

        // $debug = "ID being queried: " . $id . "<br>";
        // $debug .= "Entry found: " . (($entry) ? "Yes" : "No") . "<br>";

        // First check if details exist without the join
        $detailsModel = new JournalDetailsModel();
        $simpleDetails = $detailsModel->where('journal_entry_id', $id)->findAll();

        // $debug .= "Details found (simple query): " . count($simpleDetails) . "<br>";
        // $debug .= "Last query: " . $detailsModel->getLastQuery() . "<br>";

        // Now try with the join
        $db = db_connect();
        $builder = $db->table('journal_entry_details');
        $builder->select('journal_entry_details.*, journal_entry_details.id as detail_id, accounts.id as account_id, accounts.account_name as account_name');
        $builder->join('accounts', 'journal_entry_details.account_id = accounts.id', 'left');
        $builder->where('journal_entry_details.journal_entry_id', $id);

        // Get the SQL for debugging
        // $debug .= "Join query: " . $builder->getCompiledSelect(false) . "<br>";

        $query = $builder->get();
        $details = $query->getResultArray();

        // $debug .= "Details with accounts found: " . count($details) . "<br>";

        // For testing purposes, log debug info
        // log_message('debug', $debug);

        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $data = [
            'entry' => $entry,
            'details' => $details,
            'title' => 'Journal - ' . $entry['reference'],
            'userInfo' => $userInfo,

        ];

        return view('accounting/journal_view', $data);
    }

    public function remittances()
    {
        helper('form');

        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $memberModel = new MembersModel();
        $members = $memberModel->findAll();

        $data = [
            'title' => 'Remittances',
            'userInfo' => $userInfo,
            'members' => $members

        ];
        return view('accounting/remittances', $data);
    }

    public function remittanceCreate()
    {
        $user = session()->get('loggedInUser');
        $journalModel = new JournalEntryModel();
        $journalDetailsModel = new JournalDetailsModel();
        $transactionModel = new TransactionsModel();
        $memberModel = new MembersModel();
        $savingsAccountModel = new SavingsAccountModel();
        $sharesAccountModel = new SharesAccountModel();

        $transactions = $this->request->getJSON(true)['transactions'];

        $db = \Config\Database::connect();
        $db->transStart();

        foreach ($transactions as $tx) {
            $txReference = md5($tx['memberNumber'] . $tx['date'] . $tx['amount'] . $tx['service']);

            $existingTransaction = $transactionModel
                ->where('reference', $txReference)
                ->first();

            if ($existingTransaction) {
                continue; // Skip this one
            }


            if ($tx['service'] === 'loans' && !empty($tx['loanId'])) {
                $loanData = [
                    'loan_id' => $tx['loanId'],
                    'amount' => $tx['amount'],
                    'payment_date' => $tx['date'],
                    'payment_method' => $tx['paymentMethod'],
                    'description' => $tx['description'],
                ];

                $loanService = new LoanService();
                $loanService->handleRepayment($loanData);
            }
            $transactionData = [
                'member_number' => $tx['memberNumber'],
                'service_transaction' => $tx['service'],
                'transaction_type' => $tx['transactionType'],
                'amount' => $tx['amount'],
                'payment_method' => $tx['paymentMethod'],
                'transaction_date' => $tx['date'],
                'description' => $tx['description'],
                'reference' => $txReference,
            ];
            $transactionID = $transactionModel->insert($transactionData);

            $memberId = $memberModel->where('member_number', $tx['memberNumber'])->first();

            // Handle savings logic
            if ($tx['service'] === 'savings') {
                $savingsAccount = $savingsAccountModel->where('member_id', $memberId['id'])->first();

                if ($savingsAccount) {

                    // Update savings account balance
                    $newBalance = ($tx['service'] === 'savings')
                        ? $savingsAccount['balance'] + $tx['amount']
                        : $savingsAccount['balance'] - $tx['amount'];

                    $savingsAccountModel->update($savingsAccount['id'], [
                        'balance' => $newBalance
                    ]);
                }
            } else if ($tx['service'] === 'share_deposits') {
                $sharesAccount = $sharesAccountModel->where('member_id', $memberId['id'])->first();

                if ($sharesAccount) {

                    // Update savings account balance
                    $newBalance = ($tx['service'] === 'share_deposits')
                        ? $sharesAccount['shares_owned'] + $tx['amount']
                        : $sharesAccount['shares_owned'] - $tx['amount'];

                    $sharesAccountModel->update($sharesAccount['id'], [
                        'shares_owned' => $newBalance
                    ]);
                }
            }


            // Step 1: Create a Journal Entry
            $journalData = [
                'date' => $tx['date'],
                'description' => $tx['description'],
                'reference' => $txReference, // Unique reference number
                'created_by' => session()->get('loggedInUser'),
                'posted' => 0 // Not posted yet
            ];
            $journalEntryID = $journalModel->insert($journalData);

            // Step 2: Identify Debit & Credit Accounts
            $debitAccount = $this->getDebitAccount($tx['service'], $memberId['id']);
            $creditAccount = $this->getCreditAccount($tx['service']);

            // Step 3: Save Journal Entry Details (Debit & Credit)
            $journalDetailsModel->insert([
                'journal_entry_id' => $journalEntryID,
                'account_id' => $debitAccount,
                'debit' => $tx['amount'],
                'credit' => 0.00,
                'transaction_id' => $transactionID
            ]);

            $journalDetailsModel->insert([
                'journal_entry_id' => $journalEntryID,
                'account_id' => $creditAccount,
                'debit' => 0.00,
                'credit' => $tx['amount'],
                'transaction_id' => $transactionID
            ]);
        }
        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON(['success' => false, 'message' => 'Transaction failed.']);
        }

        return $this->response->setJSON(['success' => true]);
    }

    // Function to determine the Debit Account
    private function getDebitAccount($serviceTransaction, $memberId)
    {
        $accounts = [
            'savings' => 3, // Current Bank Account (Asset)
            'loans' => 3,
            'entrance_fee' => 3,
            'share_deposits' => 3,
        ];
        return $accounts[$serviceTransaction] ?? 5; // Default to Cash in Hand
    }

    // Function to determine the Credit Account
    private function getCreditAccount($serviceTransaction)
    {
        $accounts = [
            'savings' => 74,        // Member Savings Control
            'share_deposits' => 73, // Share Capital Control
            'loans' => 2,          // Loan Repayment Control
            'entrance_fee' => 75,   // Entrance Fee (Income/Equity)
        ];

        return $accounts[$serviceTransaction] ?? 5; // Default to Cash in Hand
    }

    public function getMemberSavingsAccount($memberId)
    {
        $savingsAccountModel = new SavingsAccountModel();
        $savingsAccountId = $savingsAccountModel->where('member_id', $memberId)->first();

        // log_message('debug', 'Savings account ID: ' . print_r($savingsAccountId, true));
        return $savingsAccountId['id'];
    }
    public function getMemberSharesAccount($memberId)
    {
        $sharesAccountModel = new SharesAccountModel();
        $sharesAccountId = $sharesAccountModel->where('member_id', $memberId)->first();

        // log_message('debug', 'Shares account ID: ' . print_r($sharesAccountId, true));
        return $sharesAccountId['id'];
    }
}

