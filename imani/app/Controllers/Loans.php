<?php

namespace App\Controllers;

use App\Controllers\Accounting\JournalService;
use App\Controllers\BaseController;
use App\Controllers\Auth;
use App\Models\LoanGuarantorModel;
use App\Models\LoansModel;
use App\Models\UserModel;
use Dompdf\Dompdf;
use App\Libraries\Pdf;
use App\Models\Accounting\AccountsModel;
use App\Models\Accounting\JournalDetailsModel;
use App\Models\Accounting\JournalEntryModel;
use App\Models\InterestTypeModel;
use App\Models\LoanApplicationModel;
use App\Models\LoanTypeModel;
use App\Models\LoanRepaymentModel;
use CodeIgniter\HTTP\ResponseInterface;
use DateTime;

class Loans extends BaseController
{
    // apply form page
    public function index()
    {
        helper(['form, url']);

        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);
        $loanType = new LoanTypeModel();
        $types = $loanType->findAll();

        $data = [
            'title' => 'Loan Application',
            'userInfo' => $userInfo,
            'loanTypes' => $types
        ];
        return view('loans/new', $data);
    }

    public function allLoans()
    {

        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $loanModel = new LoanApplicationModel();
        $loans = $loanModel->getAllApplicationsWithDetails();

        $data = [
            'title' => 'Loan Applications',
            'loans' => $loans,
            'userInfo' => $userInfo
        ];

        return view('loans/index', $data);
    }

    public function settingsPage()
    {
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);
        $interestTypeModel = new InterestTypeModel();
        $interestTypes = $interestTypeModel->findAll();

        $data = [
            'title' => 'Loan Settings',
            'userInfo' => $userInfo,
            'interestTypes' => $interestTypes
        ];
        return view('loans/loan_type_add', $data);
    }

    public function createLoanType()
    {
        $accountsModel = new AccountsModel();
        $request = $this->request;

        $data = [
            'loan_name' => $request->getPost('loan-name'),
            'service_charge' => $request->getPost('service-charge'),
            'interest_type_id' => $request->getPost('interest-type'),
            'interest_rate' => $request->getPost('interest-rate'),
            'insurance_premium' => $request->getPost('insurance-premium'),
            'crb_amount' => $request->getPost('crb'),
            'min_repayment_period' => $request->getPost('minimum-repayment-period'),
            'max_repayment_period' => $request->getPost('maximum-repayment-period'),
            'min_loan_limit' => $request->getPost('minimum-loan-limit'),
            'max_loan_limit' => $request->getPost('maximum-loan-limit'),
            'description' => $request->getPost('description'),
        ];

        // Save $data to your DB using model
        $model = new \App\Models\LoanTypeModel();
        $model->insert($data);

        $accountsModel->insert([
            'account_name' => $request->getPost('loan-name'),
            'account_code' => $this->request->getPost('account-code'),
            'category' => 'Asset',
            'parent_id' => 3,
        ]);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function updateLoanType($id)
    {
        $accountsModel = new AccountsModel();
        $request = $this->request;

        $data = [
            'loan_name' => $request->getPost('loan-name'),
            'service_charge' => $request->getPost('service-charge'),
            'interest_type_id' => $request->getPost('interest-type'),
            'interest_rate' => $request->getPost('interest-rate'),
            'insurance_premium' => $request->getPost('insurance-premium'),
            'crb_amount' => $request->getPost('crb'),
            'min_repayment_period' => $request->getPost('minimum-repayment-period'),
            'max_repayment_period' => $request->getPost('maximum-repayment-period'),
            'min_loan_limit' => $request->getPost('minimum-loan-limit'),
            'max_loan_limit' => $request->getPost('maximum-loan-limit'),
            'description' => $request->getPost('description'),
        ];

        // Save $data to your DB using model
        $model = new \App\Models\LoanTypeModel();
        $model->update($id, $data);


        return $this->response->setJSON(['status' => 'success']);
    }



    public function getInterest($id = null)
    {
        $loanTypeModel = new LoanTypeModel();
        $loanType = $loanTypeModel->find($id);

        if ($loanType) {
            $interestTypeId = $loanType['interest_type_id'];
        } else {
            $interestTypeId = 1;
        }
        $interestTypeModel = new InterestTypeModel();
        $interest = $interestTypeModel->find($interestTypeId);

        if ($interest) {
            return $this->response->setJSON([
                'name' => $interest['name'],
                'interest' => $loanType['interest_rate'],
                'crb_amount' => $loanType['crb_amount'],
                'service_charge' => $loanType['service_charge'],
                'insurance_premium' => $loanType['insurance_premium']
            ]);
        }

        return $this->response->setJSON(['error' => 'Interest not found'])->setStatusCode(404);
    }

    public function submit()
    {
        $data = $this->request->getJSON(true); // Decode JSON body into array

        $loanModel = new LoanApplicationModel();
        $guarantorModel = new LoanGuarantorModel();

        // Save loan application
        $loanData = [
            'member_id' => $data['member_id'],
            'loan_type_id' => $data['loan_type'],
            'interest_method' => $data['interest_method'],
            'interest_rate' => $data['interest_rate'],
            'insurance_premium' => $data['insurance_premium'],
            'crb_amount' => $data['crb_amount'],
            'service_charge' => $data['service_charge'],
            'principal' => $data['principal'],
            'repayment_period' => $data['repayment_period'],
            'request_date' => $data['request_date'],
            'total_loan' => $data['total_loan'],
            'total_interest' => $data['total_interest'],
            'fees' => $data['fees'],
            'monthly_repayment' => $data['monthly_repayment'],
            'disburse_amount' => $data['disburse_amount'],
            'loan_status' => 'pending'
        ];

        $loanModel->insert($loanData);
        $loanAppId = $loanModel->getInsertID();

        // Save guarantors
        if (!empty($data['guarantors'])) {
            foreach ($data['guarantors'] as $guarantor) {
                $guarantorModel->insert([
                    'loan_application_id' => $loanAppId,
                    'guarantor_member_no' => $guarantor['member_number'],
                    'name' => $guarantor['name'],
                    'mobile' => $guarantor['mobile'],
                    'amount' => $guarantor['amount'],
                ]);
            }
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Loan application submitted successfully',
            'loan_id' => $loanAppId
        ])->setStatusCode(ResponseInterface::HTTP_CREATED);
    }

    public function view($id = null)
    {
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $loanModel = new LoanApplicationModel();
        $loan = $loanModel->getApplicationWithDetails($id);

        $data = [
            'title' => 'Loan Details',
            'userInfo' => $userInfo,
            'loan' => $loan
        ];
        return view('loans/loan_details', $data);
    }

    public function loanTypes()
    {
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $loanTypeModel = new LoanTypeModel();
        $loanTypes = $loanTypeModel->getLoanTypes();

        $data = [
            'title' => 'Loan Types',
            'userInfo' => $userInfo,
            'types' => $loanTypes
        ];
        return view('loans/loan_type_page', $data);
    }

    public function typeView($id = null)
    {
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $loanTypeModel = new LoanTypeModel();
        $loanType = $loanTypeModel->getLoanType($id);

        $interestTypeModel = new InterestTypeModel();
        $interestTypes = $interestTypeModel->findAll();

        $data = [
            'title' => 'Loan Type - ' . $loanType['loan_name'],
            'userInfo' => $userInfo,
            'type' => $loanType,
            'interestTypes' => $interestTypes
        ];

        return view('loans/loan_type_edit', $data);
    }


    public function approveLoan($id)
    {
        $user = session()->get('loggedInUser');
        $loanModel = new LoanApplicationModel();
        $loan = $loanModel->find($id);

        if (!$loan) {
            return redirect()->back()->with('error', 'Loan not found');
        }

        // Update status
        $loanModel->update($id, ['loan_status' => 'approved']);

        // Generate installment schedule
        $loanService = new LoanService();
        $loanService->generateInstallments($id);

        $loanData = $loanModel->find($id);
        $journalService = new JournalService();
        $journalService->createLoanDisbursementEntry($loanData, $user);

        return redirect()->back()->with('success', 'Loan approved and installments generated.');
    }

    public function checkLoan($memberNumber)
    {
        $loanModel = new \App\Models\LoanApplicationModel();

        // Get latest *approved* loan for that member
        $loan = $loanModel
            ->where('member_id', $memberNumber)
            ->where('loan_status', 'approved')
            ->orderBy('id', 'DESC')
            ->first();

        if ($loan) {
            return $this->response->setJSON([
                'loan_id'     => $loan['id'],
                'loan_amount' => $loan['principal'],
            ]);
        } else {
            return $this->response->setJSON([
                'message' => 'No active loan found',
            ]);
        }
    }


}

class LoanService
{
    public function generateInstallments($loanId)
    {
        $loanModel = new LoanApplicationModel();
        $repaymentModel = new LoanRepaymentModel();

        $loan = $loanModel->find($loanId);

        if (!$loan || $loan['loan_status'] !== 'approved') {
            return false;
        }

        $installments = [];
        $startDate = new DateTime($loan['request_date']);
        $monthlyAmount = $loan['monthly_repayment'];
        $period = (int) $loan['repayment_period'];

        for ($i = 1; $i <= $period; $i++) {
            $dueDate = clone $startDate;
            $dueDate->modify("+{$i} months");

            $installments[] = [
                'loan_id'           => $loanId,
                'installment_number' => $i,
                'due_date'          => $dueDate->format('Y-m-d'),
                'amount_due'        => $monthlyAmount,
                'amount_paid'       => 0.00,
                'status'            => 'pending',
            ];
        }

        return $repaymentModel->insertBatch($installments);
    }

    public function handleRepayment($data)
    {
        $loanId = $data['loan_id'];
        $amountPaid = floatval($data['amount']);
        $paymentDate = $data['payment_date'] ?? date('Y-m-d');
        $paymentMethod = $data['payment_method'] ?? 'unknown';
        $description = $data['description'] ?? '';
        $user = session()->get('loggedInUser');

        $repaymentModel = new \App\Models\LoanRepaymentModel();
        $installments = $repaymentModel
            ->where('loan_id', $loanId)
            ->where('status', 'unpaid')
            ->orderBy('due_date', 'ASC')
            ->findAll();

        $remaining = $amountPaid;

        foreach ($installments as $installment) {
            if ($remaining <= 0) break;

            $due = $installment['amount_due'] - $installment['amount_paid'];
            $payNow = min($due, $remaining);

            $repaymentModel->update($installment['id'], [
                'amount_paid' => $installment['amount_paid'] + $payNow,
                'payment_date' => $paymentDate,
                'status' => ($installment['amount_paid'] + $payNow >= $installment['amount_due']) ? 'paid' : 'unpaid',
            ]);

            $remaining -= $payNow;
        }

        // Create journal entry
        $journalService = new JournalService();
        $journalService->createLoanRepaymentEntry([
            'loan_id' => $loanId,
            'amount_paid' => $amountPaid,
            'payment_date' => $paymentDate,
            'description' => $description,
            'payment_method' => $paymentMethod,
        ], $user);
    }
}
