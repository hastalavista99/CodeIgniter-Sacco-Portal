<?php

namespace App\Controllers\Accounting;

use App\Controllers\BaseController;
use App\Models\Accounting\AccountsModel;
use App\Models\Accounting\JournalDetailsModel;
use App\Models\Accounting\JournalEntryModel;
use App\Models\Accounting\SavingsAccountModel;
use App\Models\Accounting\SharesAccountModel;
use App\Models\LoanApplicationModel;
use App\Models\MembersModel;
use App\Models\OrganizationModel;
use App\Models\UserModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use DateTime;

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

    public function trialBalancePdf()
    {
        try {
            $accountModel = new AccountsModel();
            $accounts = $accountModel->findAll();

            $orgModel = new \App\Models\OrganizationModel();

            $organization = $orgModel->first();
            if (!$organization) {
                return $this->response->setStatusCode(500)->setBody('Organization profile is missing.');
            }

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
                'totalCredit' => $totalCredit,
                'organization' => $organization
            ];

            $html = view('accounting/trial_balance_pdf', $data);

            $options = new Options();
            $options->set('defaultFont', 'DejaVu Sans');
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            return $this->response
                ->setHeader('Content-Type', 'application/pdf')
                ->setBody($dompdf->output());
        } catch (\Throwable $e) {
            log_message('error', 'Error generating trial balance PDF: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setBody('Unable to generate trial balance PDF.');
        }
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

                $balance = ($category === 'asset') ? ($debits - $credits) : ($credits - $debits);

                $balanceSheet[$category][] = [
                    'account_name' => $account['account_name'],
                    'balance' => $balance
                ];

                $total += $balance;
            }

            $balanceSheet['totals'][$category] = $total;
        }

        // ✅ Calculate current period surplus/deficit
        $incomeAccounts = $accountModel->where('category', 'income')->findAll();
        $expenseAccounts = $accountModel->where('category', 'expense')->findAll();

        $incomeTotal = 0;
        foreach ($incomeAccounts as $account) {
            $debit = $journalDetailModel->where('account_id', $account['id'])->selectSum('debit')->get()->getRow()->debit ?? 0;
            $credit = $journalDetailModel->where('account_id', $account['id'])->selectSum('credit')->get()->getRow()->credit ?? 0;
            $incomeTotal += ($credit - $debit);
        }

        $expenseTotal = 0;
        foreach ($expenseAccounts as $account) {
            $debit = $journalDetailModel->where('account_id', $account['id'])->selectSum('debit')->get()->getRow()->debit ?? 0;
            $credit = $journalDetailModel->where('account_id', $account['id'])->selectSum('credit')->get()->getRow()->credit ?? 0;
            $expenseTotal += ($debit - $credit);
        }

        $netProfit = $incomeTotal - $expenseTotal;

        // ✅ Append to equity section
        $balanceSheet['equity'][] = [
            'account_name' => 'Current Period Surplus/Deficit',
            'balance' => $netProfit
        ];

        // ✅ Update equity total
        $balanceSheet['totals']['equity'] += $netProfit;

        $data = [
            'balanceSheet' => $balanceSheet,
            'title' => 'Balance Sheet',
            'userInfo' => $userInfo
        ];

        return view('accounting/balance_sheet', $data);
    }


    public function balanceSheetPdf()
    {
        try {
            $userModel = new UserModel();
            $loggedInUserId = session()->get('loggedInUser');
            $userInfo = $userModel->find($loggedInUserId);

            $orgModel = new \App\Models\OrganizationModel();

            $organization = $orgModel->first();
            if (!$organization) {
                return $this->response->setStatusCode(500)->setBody('Organization profile is missing.');
            }

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

                    $balance = 0;
                    if ($category === 'asset') {
                        $balance = $debits - $credits;
                    } else {
                        $balance = $credits - $debits;
                    }

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
                'userInfo' => $userInfo,
                'organization' => $organization
            ];

            $html = view('accounting/balance_sheet_pdf', $data);

            $options = new Options();
            $options->set('defaultFont', 'DejaVu Sans');
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            return $this->response
                ->setHeader('Content-Type', 'application/pdf')
                ->setBody($dompdf->output());
        } catch (\Throwable $e) {
            log_message('error', 'Error generating balance sheet PDF: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setBody('Unable to generate balance sheet.');
        }
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

    public function incomeStatementPdf()
    {
        try {
            $userModel = new UserModel();
            $loggedInUserId = session()->get('loggedInUser');
            $userInfo = $userModel->find($loggedInUserId);

            $accountModel = new AccountsModel();
            $journalDetailModel = new JournalDetailsModel();
            $orgModel = new \App\Models\OrganizationModel();

            $organization = $orgModel->first();
            if (!$organization) {
                return $this->response->setStatusCode(500)->setBody('Organization profile is missing.');
            }

            $categories = ['income', 'expense'];
            $incomeStatement = [];

            foreach ($categories as $category) {
                $accounts = $accountModel->where('category', $category)->findAll();
                $total = 0;

                foreach ($accounts as $account) {
                    $debits = $journalDetailModel->where('account_id', $account['id'])->selectSum('debit')->get()->getRow()->debit ?? 0;
                    $credits = $journalDetailModel->where('account_id', $account['id'])->selectSum('credit')->get()->getRow()->credit ?? 0;

                    $balance = ($category === 'income') ? ($credits - $debits) : ($debits - $credits);

                    $incomeStatement[$category][] = [
                        'account_name' => $account['account_name'],
                        'balance' => $balance
                    ];

                    $total += $balance;
                }

                $incomeStatement['totals'][$category] = $total;
            }

            $incomeStatement['net_profit'] = $incomeStatement['totals']['income'] - $incomeStatement['totals']['expense'];

            $data = [
                'incomeStatement' => $incomeStatement,
                'title' => 'Income Statement',
                'userInfo' => $userInfo,
                'organization' => $organization
            ];

            // Load PDF view
            $html = view('accounting/income_statement_pdf', $data);

            $options = new Options();
            $options->set('defaultFont', 'DejaVu Sans');
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            return $this->response
                ->setHeader('Content-Type', 'application/pdf')
                ->setBody($dompdf->output());
        } catch (\Throwable $e) {
            log_message('error', 'Error generating income statement PDF: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setBody('Unable to generate income statement.');
        }
    }



    // Balances for all members
    public function valueBalancesPdf()
    {
        try {
            $memberModel = new MembersModel();
            $orgModel = new OrganizationModel();
            $savingsModel = new SavingsAccountModel();
            $sharesModel = new SharesAccountModel();
            $loanModel = new LoanApplicationModel();

            $organization = $orgModel->first();
            $members = $memberModel->findAll();

            if (!$organization) {
                return $this->response->setStatusCode(500)->setBody('Organization profile missing.');
            }

            $rows = [];

            foreach ($members as $member) {
                $memberId = $member['id'];

                $savings = $savingsModel->getMemberSavingsTotal($memberId);
                $shares = $sharesModel->getMemberSharesTotal($memberId);
                $loans = $loanModel->getMemberLoanSummary($memberId);

                $rows[] = [
                    'member_number' => $member['member_number'],
                    'name' => $member['first_name'] . ' ' . $member['last_name'],
                    'savings' => number_format($savings ?? 0, 2),
                    'shares' => number_format($shares ?? 0, 2),
                    'loan_balance' => number_format($loans[0]['balance'] ?? 0, 2),
                ];
            }

            $data = [
                'organization' => $organization,
                'rows' => $rows
            ];

            $html = view('accounting/all_member_balances_pdf', $data);

            $options = new Options();
            $options->set('defaultFont', 'DejaVu Sans');
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();

            return $this->response
                ->setHeader('Content-Type', 'application/pdf')
                ->setBody($dompdf->output());

        } catch (\Throwable $e) {
            log_message('error', 'Balance report error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setBody('Error generating report.');
        }
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
        $end = $this->request->getGet('end');

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

    public function exportSchedulePdf($loanId)
    {
        $loanModel = new \App\Models\LoanApplicationModel();
        $repaymentModel = new \App\Models\LoanRepaymentModel();
        $memberModel = new \App\Models\MembersModel();
        $orgModel = new \App\Models\OrganizationModel();


        $organization = $orgModel->first();
        if (!$organization) {
            return $this->response->setStatusCode(500)->setBody('Organization profile is missing.');
        }
        $loan = $loanModel->find($loanId);
        $member = $memberModel->find($loan['member_id']);

        // Generate amortization data (reuse from above method)
        $P = (float) $loan['principal'];
        $annualRate = (float) $loan['interest_rate'] / 100;
        $monthlyRate = $annualRate / 12;
        $n = (int) $loan['repayment_period'];
        $EMI = ($P * $monthlyRate * pow(1 + $monthlyRate, $n)) / (pow(1 + $monthlyRate, $n) - 1);
        $EMI = round($EMI, 2);
        $balance = $P;
        $schedule = [];

        for ($i = 1; $i <= $n; $i++) {
            $interest = round($balance * $monthlyRate, 2);
            $principal = round($EMI - $interest, 2);
            $newBalance = round($balance - $principal, 2);

            if ($i === $n && $newBalance !== 0.00) {
                $principal += $newBalance;
                $EMI = $principal + $interest;
                $newBalance = 0.00;
            }

            $schedule[] = [
                'installment' => $i,
                'due_date' => (new DateTime($loan['request_date']))->modify("+$i months")->format('Y-m-d'),
                'principal' => $principal,
                'interest' => $interest,
                'total' => $EMI,
                'balance' => $newBalance,

            ];

            $balance = $newBalance;
        }

        $html = view('loans/amortization_schedule_pdf', [
            'loan' => $loan,
            'schedule' => $schedule,
            'member' => $member,
            'organization' => $organization
        ]);

        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('amortization_schedule_loan_' . $loanId . '.pdf', ['Attachment' => false]);
    }

    public function generalLedger()
    {
        helper('form');
        $userModle = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModle->find($loggedInUserId);

        $accountModel = new AccountsModel();
        $journalModel = new JournalDetailsModel();

        $start = $this->request->getPost('start_date') ?? date('Y-m-01');
        $end = $this->request->getPost('end_date') ?? date('Y-m-d');
        $accountId = $this->request->getPost('account_id');

        $query = $journalModel
            ->select('journal_entries.date, journal_entries.description, journal_entries.reference, journal_entry_details.debit, journal_entry_details.credit')
            ->join('journal_entries', 'journal_entries.id = journal_entry_details.journal_entry_id')
            ->where('journal_entries.date >=', $start)
            ->where('journal_entries.date <=', $end);

        if (!empty($accountId)) {
            $query->where('journal_entry_details.account_id', $accountId);
        }

        $data = [
            'accounts' => $accountModel->findAll(),
            'entries' => $query->orderBy('journal_entries.date', 'ASC')->findAll(),
            'userInfo' => $userInfo,
            'title' => 'General Ledger',
            'startDate' => $start,
            'endDate' => $end,
            'accountId' => $accountId
        ];

        return view('accounting/general_ledger', $data);
    }


    public function generalLedgerPdf()
    {
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');
        $accountId = $this->request->getGet('account_id');

        $journalModel = new JournalDetailsModel();

        $query = $journalModel
            ->select('journal_entries.date, journal_entries.description, journal_entries.reference, journal_entry_details.debit, journal_entry_details.credit, accounts.account_name')
            ->join('journal_entries', 'journal_entries.id = journal_entry_details.journal_entry_id')
            ->join('accounts', 'accounts.id = journal_entry_details.account_id')
            ->where('journal_entries.date >=', $startDate)
            ->where('journal_entries.date <=', $endDate);

        if (!empty($accountId)) {
            $query->where('journal_entry_details.account_id', $accountId);
        }

        $entries = $query->orderBy('journal_entries.date', 'ASC')->findAll();

        if (empty($entries)) {
            return $this->response->setStatusCode(404)->setBody('No entries found for the specified date range.');
        }

        $orgModel = new \App\Models\OrganizationModel();

        $organization = $orgModel->first();
        if (!$organization) {
            return $this->response->setStatusCode(500)->setBody('Organization profile is missing.');
        }

        $data = [
            'entries' => $entries,
            'organization' => $organization,
            'startDate' => $startDate,
            'endDate' => $endDate
        ];

        $html = view('accounting/gl_pdf', $data);

        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("general_ledger.pdf", ["Attachment" => true]);
    }

    public function generalLedgerExcel()
    {
        $journalModel = new JournalDetailsModel();

        $start = $this->request->getGet('start_date') ?? date('Y-m-01');
        $end = $this->request->getGet('end_date') ?? date('Y-m-d');
        $accountId = $this->request->getGet('account_id');

        $query = $journalModel
            ->select('journal_entries.date, journal_entries.description, journal_entries.reference, journal_entry_details.debit, journal_entry_details.credit, accounts.account_name')
            ->join('journal_entries', 'journal_entries.id = journal_entry_details.journal_entry_id')
            ->join('accounts', 'accounts.id = journal_entry_details.account_id')
            ->where('journal_entries.date >=', $start)
            ->where('journal_entries.date <=', $end);

        if (!empty($accountId)) {
            $query->where('journal_entry_details.account_id', $accountId);
        }

        $entries = $query->orderBy('journal_entries.date', 'ASC')->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Date');
        $sheet->setCellValue('B1', 'Account');
        $sheet->setCellValue('C1', 'Reference');
        $sheet->setCellValue('D1', 'Description');
        $sheet->setCellValue('E1', 'Debit');
        $sheet->setCellValue('F1', 'Credit');

        $row = 2;
        foreach ($entries as $entry) {
            $sheet->setCellValue("A{$row}", $entry['date']);
            $sheet->setCellValue("B{$row}", $entry['account_name']);
            $sheet->setCellValue("C{$row}", $entry['reference']);
            $sheet->setCellValue("D{$row}", $entry['description']);
            $sheet->setCellValue("E{$row}", $entry['debit']);
            $sheet->setCellValue("F{$row}", $entry['credit']);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'General_Ledger.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        $writer->save("php://output");
        exit;
    }
}
