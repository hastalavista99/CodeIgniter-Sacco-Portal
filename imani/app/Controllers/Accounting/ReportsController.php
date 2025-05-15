<?php

namespace App\Controllers\Accounting;

use App\Controllers\BaseController;
use App\Models\Accounting\AccountsModel;
use App\Models\Accounting\JournalDetailsModel;
use App\Models\Accounting\JournalEntryModel;
use App\Models\UserModel;
use Dompdf\Dompdf;
use Dompdf\Options;

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
                'account_name' => $account['account_name'],
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

        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

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
        $data = [
            'incomeStatement' => $incomeStatement,
            'title' => 'Income Statement',
            'userInfo' => $userInfo
        ];

        return view('accounting/income_statement', $data);
    }

    public function cashBook()
    {
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-01');
        $endDate = $this->request->getGet('end_date') ?? date('Y-m-d');
        $accountId = $this->request->getGet('account_id') ?? null;

        $detailsModel = new JournalDetailsModel();
        $entries = $detailsModel->getCashbookEntries($startDate, $endDate, $accountId);



        $accountsModel = new AccountsModel();
        $cashAccounts = $accountsModel->getCashAccounts();

        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $data = [
            'title' => 'Cash Book',
            'entries' => $entries,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'cashAccounts' => $cashAccounts,
            'selectedAccount' => $accountId,
            'userInfo' => $userInfo
        ];

        return view('accounting/cash_book', $data);
    }

    public function cashbookPdf()
    {
        $journalModel = new JournalEntryModel();
        $detailModel = new JournalDetailsModel();
        $accountModel = new AccountsModel();
        $orgModel = new \App\Models\OrganizationModel();

        $start = $this->request->getGet('start');
        $end   = $this->request->getGet('end');

        $organization = $orgModel->first();
            if (!$organization) {
                return $this->response->setStatusCode(500)->setBody('Organization profile is missing.');
            }

        // Fetch cashbook data
        $cashbookData = $detailModel->getCashbookEntries($start, $end); // Assuming you have this method

        $data = [
            'organization' => $organization,
            'entries' => $cashbookData,
            'generatedAt' => date('Y-m-d H:i:s'),
            'startDate' => $start,
            'endDate' => $end,
        ];

        // Load the view
        $html = view('accounting/cashbook_pdf', $data);
        $options = new \Dompdf\Options();
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape'); // or 'portrait'
        $dompdf->render();

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setBody($dompdf->output());
    }
}
