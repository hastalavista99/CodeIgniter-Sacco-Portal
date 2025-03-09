<?php

namespace App\Controllers\Accounting;

use App\Controllers\BaseController;
use App\Models\Accounting\JournalEntryModel;
use App\Models\Accounting\JournalDetailsModel;

use App\Models\UserModel;

class JournalController extends BaseController
{
    public function page()
    {
        helper(['form', 'url']);

        $model = new JournalEntryModel();
        $journals = $model->findAll();
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $data = [
            'title' => 'Journal Entries',
            'entries' => $journals,
            'userInfo' => $userInfo
        ];
        return view('accounting/journal_list', $data);
    }

    public function createPage()
    {
        helper('form');

        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $data = [
            'title' => 'Create New Entry',
            'userInfo' => $userInfo
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
            'debit'            => 'required_without_all[credit]|decimal',
            'credit'           => 'required_without_all[debit]|decimal',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $journalEntryModel = new JournalEntryModel();
        $journalDetailModel = new JournalDetailsModel();

        // Insert into journal_entries table
        $entryData = [
            'date'             => $this->request->getPost('transaction_date'),
            'description'      => $this->request->getPost('description'),
            'reference'        => $this->request->getPost('reference'),
            'created_by'       => 1, // Change this to the logged-in user ID
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
                'account_name'     => $account,
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
}
