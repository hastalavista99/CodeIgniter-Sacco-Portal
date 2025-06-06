<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BalancesModel;
use App\Models\PaymentsModel;
use App\Models\UserModel;
use App\Models\MembersModel;
use App\Models\Accounting\TransactionsModel;
use App\Models\Accounting\SavingsAccountModel;
use App\Models\Accounting\SharesAccountModel;
use App\Models\LoanApplicationModel;
use App\Models\LoanRepaymentModel;
use App\Models\StaffModel;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{
    public function index()
    {

        $paymentsModel = new PaymentsModel();
        $memberModel = new MembersModel();
        $savingsModel = new SavingsAccountModel();
        $sharesModel = new SharesAccountModel();
        $loanModel = new LoanApplicationModel();
        $repaymentModel = new LoanRepaymentModel();
        $transactionsModel = new TransactionsModel();
        $staffModel = new StaffModel();

        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        if ($userInfo['role'] === 'member') {
            $member = $memberModel->where('member_number', $userInfo['member_no'])->first();
            $memberId = $member['id'];

            $savings = $savingsModel->getMemberSavingsTotal($memberId);
            $shares = $sharesModel->getMemberSharesTotal($memberId);
            $loans = $loanModel->getMemberLoanSummary($memberId);
            $transactions = $transactionsModel->getRecentTransactions($member['member_number']);
        } else {
            $savings = $savingsModel->getTotalSavings();
            $shares = $sharesModel->getTotalShares();
            $loans = $loanModel->getTotalLoans();
            $totalMembers = $memberModel->getActiveMembers();
        }

        $payments = $paymentsModel
            ->where('SUBSTRING(BillRefNumber, -10) =', $userInfo['mobile'])
            ->orderBy('mp_date', 'DESC')
            ->findAll(5);

        // Transaction activity for chart (last 6 months)
        $months = [];
        $depositData = [];
        $sharesData = [];
        $repaymentData = [];


        $memberNo = $userInfo['role'] === 'member' ? $userInfo['member_no'] : null;

        for ($i = 5; $i >= 0; $i--) {
            $monthLabel = date('M', strtotime("-$i months"));
            $yearMonth = date('Y-m', strtotime("-$i months"));

            $months[] = $monthLabel;

            $depositData[] = $transactionsModel->getMonthlyTotal('savings', $yearMonth, $memberNo);
            $sharesData[] = $transactionsModel->getMonthlyTotal('share_deposits', $yearMonth, $memberNo);
            $repaymentData[] = $transactionsModel->getMonthlyTotal('loan', $yearMonth, $memberNo);
            $staffNumber = $staffModel->getActiveStaffMembers();
        }


        // data for loans vs repayments chart
        $loanData = $loanModel
            ->select("DATE_FORMAT(request_date, '%Y-%m') as month, SUM(disburse_amount) as total_loans")
            ->groupBy('month')
            ->orderBy('month')
            ->findAll();

        $loanRepaymentData = $repaymentModel
            ->select("DATE_FORMAT(updated_at, '%Y-%m') as month, SUM(amount_paid) as total_repayments")
            ->groupBy('month')
            ->orderBy('month')
            ->findAll();

        $loansPerMonth = [];
        $repaymentsPerMonth = [];

        // Convert results into key-value arrays for easy lookup
        $loanMap = [];
        foreach ($loanData as $row) {
            $loanMap[$row['month']] = $row['total_loans'];
        }
        $repaymentMap = [];
        foreach ($loanRepaymentData as $row) {
            $repaymentMap[$row['month']] = $row['total_repayments'];
        }

        // Merge months
        $allMonths = array_unique(array_merge(array_keys($loanMap), array_keys($repaymentMap)));
        sort($allMonths);

        foreach ($allMonths as $month) {
            $months[] = $month;
            $loansPerMonth[] = $loanMap[$month] ?? 0;
            $repaymentsPerMonth[] = $repaymentMap[$month] ?? 0;
        }


        $data = [
            'title' => 'Dashboard',
            'userInfo' => $userInfo,
            'savings' => $savings,
            'shares' => $shares,
            'loans' => $loans,
            'payments' => $payments,
            'member' => $member ?? null,
            'members' => $totalMembers ?? null,
            'months' => $months,
            'depositData' => $depositData,
            'sharesData' => $sharesData,
            'repaymentData' => $repaymentData,
            'staffNumber' => $staffNumber ?? 0,
            'loansPerMonth' => $loansPerMonth,
            'repaymentsPerMonth' => $repaymentsPerMonth,
        ];
        return view('dashboard/index', $data);
    }
}
