<?php

namespace App\Controllers\Accounting;

use App\Controllers\BaseController;
use App\Models\Accounting\AccountsModel;
use App\Models\Accounting\JournalDetailsModel;
use App\Models\UserModel;

class ReportsController extends BaseController
{
    public function trialBalance()
    {
        $accountModel = new AccountsModel();
        $accounts = $accountModel->findAll();

        $trialBalance = [];
        $totalDebit = 0;
        $totalCredit = 0;

        foreach ($accounts as $account) {
            $debitSum = (new JournalDetailsModel())->where('account_id', $account['id'])->selectSum('debit')->get()->getRow()->debit ?? 0;
            $creditSum = (new JournalDetailsModel())->where('account_id', $account['id'])->selectSum('credit')->get()->getRow()->credit ?? 0;

            $trialBalance[] = [
                'account_name' => $account['name'],
                'debit' => $debitSum,
                'credit' => $creditSum
            ];
            $totalDebit += $debitSum;
            $totalCredit += $creditSum;
        }

        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $data = [
            'title' => 'Trial Balance',
            'userInfo' => $userInfo,
            'trialBalance' => $trialBalance,
            'totalDebit' => $totalDebit,
            'totalCredit' => $totalCredit
        ];

        return view('accounting/trial_balance', $data);
    }

    public function balanceSheet()
    {

        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $accountModel = new AccountsModel();
        $journalDetailModel = new JournalDetailsModel();

        $categories = ['asset', 'liability', 'equity'];
        $balanceSheet = [];

        foreach ($categories as $category) {
            $accounts = $accountModel->where('category', $category)->findAll();
            $total = 0;

            foreach ($accounts as $account) {
                $debits = $journalDetailModel->where('account_id', $account['id'])->selectSum('debit')->get()->getRow()->debit ?? 0;
                $credits = $journalDetailModel->where('account_id', $account['id'])->selectSum('credit')->get()->getRow()->credit ?? 0;

                // Assets: Debit Increases, Credit Decreases
                // Liabilities & Equity: Credit Increases, Debit Decreases
                $balance = ($category === 'asset') ? ($debits - $credits) : ($credits - $debits);

                $balanceSheet[$category][] = [
                    'account_name' => $account['account_name'],
                    'balance' => $balance
                ];

                $total += $balance;
            }

            $balanceSheet['totals'][$category] = $total;
        }

        $data = [
            'balanceSheet' => $balanceSheet,
            'title' => 'Balance Sheet',
            'userInfo' => $userInfo
        ];

        return view('accounting/balance_sheet', $data);
    }

    public function incomeStatement()
    {
        $accountModel = new AccountsModel();
        $journalDetailModel = new JournalDetailsModel();

        $categories = ['income', 'expense'];
        $incomeStatement = [];

        foreach ($categories as $category) {
            $accounts = $accountModel->where('category', $category)->findAll();
            $total = 0;

            foreach ($accounts as $account) {
                $debits = $journalDetailModel->where('account_id', $account['id'])->selectSum('debit')->get()->getRow()->debit ?? 0;
                $credits = $journalDetailModel->where('account_id', $account['id'])->selectSum('credit')->get()->getRow()->credit ?? 0;

                // Income: Credit Increases, Debit Decreases
                // Expense: Debit Increases, Credit Decreases
                $balance = ($category === 'income') ? ($credits - $debits) : ($debits - $credits);

                $incomeStatement[$category][] = [
                    'account_name' => $account['account_name'],
                    'balance' => $balance
                ];

                $total += $balance;
            }

            $incomeStatement['totals'][$category] = $total;
        }

        // Calculate Net Profit
        $incomeStatement['net_profit'] = $incomeStatement['totals']['income'] - $incomeStatement['totals']['expense'];

        return view('accounting/income_statement', ['incomeStatement' => $incomeStatement]);
    }
}
