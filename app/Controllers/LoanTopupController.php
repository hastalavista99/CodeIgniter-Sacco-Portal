<?php

namespace App\Controllers;

use App\Controllers\Accounting\JournalService;
use App\Models\LoanApplicationModel;
use App\Models\LoanRepaymentModel;
use App\Models\UserModel;
use App\Services\LoanService;
use CodeIgniter\Controller;

class LoanTopupController extends BaseController
{
    protected $loanModel;
    protected $repaymentModel;
    protected $loanService;
    protected $journalService;

    public function __construct()
    {
        $this->loanModel = new LoanApplicationModel();
        $this->repaymentModel = new LoanRepaymentModel();
        $this->loanService = service('loanService'); // Your existing loan service
        $this->journalService = new JournalService();
    }

    public function initiate($oldLoanId)
    {

        $userModel = new UserModel();
        $loggedInUser = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUser);
        $oldLoan = $this->loanModel->find($oldLoanId);
        if (!$oldLoan) {
            return redirect()->back()->with('error', 'Loan not found.');
        }

        $paidAmount = $this->repaymentModel->getTotalPaid($oldLoanId);
        $percentagePaid = ($paidAmount['total_paid'] / floatval($oldLoan['principal'])) * 100;
        $minPercent = get_system_parameter('loan_topup_min_percent'); // e.g., 40%

        if ($percentagePaid < $minPercent) {
            return redirect()->back()->with('error', 'Not eligible for top-up.');
        }

        return view('loans/topup_form', [
            'oldLoan' => $oldLoan,
            'percentagePaid' => $percentagePaid,
            'title' => 'Loan Top-up',
            'userInfo' => $userInfo,
            'paidAmount' => $paidAmount['total_paid']
        ]);
    }

    public function process()
    {
        $oldLoanId = $this->request->getPost('old_loan_id');
        $newLoanAmount = $this->request->getPost('new_loan_amount');

        $oldLoan = $this->loanModel->find($oldLoanId);
        $paidAmount = $this->repaymentModel->getTotalPaid($oldLoanId);
        $outstanding = $oldLoan['principal_amount'] - $paidAmount;

        $feePercent = get_system_parameter('loan_topup_fee_percent');
        $processingFee = $outstanding * ($feePercent / 100);
        $netDisbursement = $newLoanAmount - $outstanding - $processingFee;

        // Create new loan
        $newLoanId = $this->loanModel->insert([
            'member_id' => $oldLoan['member_id'],
            'principal_amount' => $newLoanAmount,
            'parent_loan_id' => $oldLoanId,
            'topup_outstanding_cleared' => $outstanding,
            'topup_processing_fee' => $processingFee,
            'status' => 'pending'
        ]);

        // Post accounting entries via LoanService
        $this->loanService->processTopUpLoan($oldLoan, $newLoanAmount, $outstanding, $processingFee, $netDisbursement);

        return redirect()->to('/loans/' . $newLoanId)->with('success', 'Top-up loan processed.');
    }

    public function processTopUpLoan($oldLoan, $newLoanAmount, $outstanding, $processingFee, $netDisbursement)
    {
        // 1. Clear old loan balance
        $this->journalService->postEntry([
            'debit_account'  => 'Old Loan Clearing',
            'credit_account' => 'Loan Portfolio',
            'amount'         => $outstanding,
            'description'    => 'Top-up loan clearance for Loan #' . $oldLoan['id']
        ]);

        // 2. Record processing fee
        $this->journalService->postEntry([
            'debit_account'  => 'Loan Processing Income',
            'credit_account' => 'Loan Portfolio',
            'amount'         => $processingFee,
            'description'    => 'Processing fee for Top-up Loan'
        ]);

        // 3. Disburse net amount
        $this->journalService->postEntry([
            'debit_account'  => 'Loan Portfolio',
            'credit_account' => 'Cash/Bank',
            'amount'         => $netDisbursement,
            'description'    => 'Net disbursement for Top-up Loan'
        ]);
    }
}
