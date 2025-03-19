<?php

namespace App\Accounting\Controllers;

use App\Models\Accounting\JournalEntryModel;
use App\Models\Accounting\AccountsModel;
use App\Models\Accounting\ClosedYearModel;
use CodeIgniter\Controller;

class YearEndController extends Controller
{
    public function index()
    {
        helper(['form', 'url']);

        $year = date('Y');
        $journalModel = new JournalEntryModel();
        $accountModel = new AccountModel();
        $closedYearModel = new ClosedYearModel();

        // Check if the year is already closed
        if ($closedYearModel->where('year', $year)->first()) {
            return view('year_end_closed', ['year' => $year]);
        }

        // Get income and expense accounts
        $incomeAccounts = $accountModel->where('type', 'income')->findAll();
        $expenseAccounts = $accountModel->where('type', 'expense')->findAll();

        // Calculate totals
        $totalIncome = $journalModel->getTotalByType('income', $year);
        $totalExpenses = $journalModel->getTotalByType('expense', $year);
        $netProfit = $totalIncome - $totalExpenses;

        return view('year_end_summary', [
            'year' => $year,
            'incomeAccounts' => $incomeAccounts,
            'expenseAccounts' => $expenseAccounts,
            'totalIncome' => $totalIncome,
            'totalExpenses' => $totalExpenses,
            'netProfit' => $netProfit
        ]);
    }

    public function closeYear()
    {
        $year = date('Y');
        $journalModel = new JournalEntryModel();
        $closedYearModel = new ClosedYearModel();

        // Prevent double closing
        if ($closedYearModel->where('year', $year)->first()) {
            return redirect()->to('/year-end')->with('error', 'Year already closed.');
        }

        // Create closing journal entry
        $netProfit = $journalModel->getTotalByType('income', $year) - $journalModel->getTotalByType('expense', $year);
        $journalModel->createClosingEntry($year, $netProfit);

        // Mark year as closed
        $closedYearModel->insert([
            'year' => $year,
            'closed_by' => session()->get('user_id')
        ]);

        return redirect()->to('/year-end')->with('success', 'Year-end closing completed.');
    }
}
