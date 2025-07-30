<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Accounting\TransactionsModel;
use App\Models\InterestTypeModel;
use App\Models\LoanApplicationModel;
use App\Models\LoanTypeModel;
use App\Models\MembersModel;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use CodeIgniter\HTTP\ResponseInterface;

class LoansController extends BaseController
{
    use ResponseTrait;

    protected $model;

    public function __construct()
    {
        $this->model = new LoanApplicationModel();
    }

    public function index($memberNo)
    {
        $memberModel = new MembersModel();
        $member = $memberModel->where('member_number', $memberNo)->first();

        if (!$member) {
            return $this->response->setJSON([
                'status' => ResponseInterface::HTTP_NOT_FOUND,
                'error' => true,
                'message' => 'Member not found',
                'data' => []
            ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }


        $model = new LoanApplicationModel();
        $loanData = $model->getMemberLoans($member['id']);


        if (empty($loanData)) {
            return $this->response->setJSON([
                'status' => ResponseInterface::HTTP_NOT_FOUND,
                'error' => true,
                'message' => 'No Loans found',
                'data' => []
            ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        return $this->response->setJSON([
            'status' => ResponseInterface::HTTP_OK,
            'error' => false,
            'message' => 'Transactions retrieved successfully',
            'data' => $loanData
        ])->setStatusCode(ResponseInterface::HTTP_OK);
    }

    public function mobileLoanApplication() {}

    public function fetchLoanTypes()
    {
        $loanTypeModel = new LoanTypeModel();
        $loanTypes = $loanTypeModel->findAll();

        return $this->respond([
            'success' => true,
            'message' => 'Loan types retrieved successfully',
            'data' => $loanTypes
        ]);
    }
    public function loanPreview()
    {
        $json = $this->request->getJSON();

        if (!isset($json->memberNumber) || !isset($json->principal) || !isset($json->repaymentPeriod) || !isset($json->loanTypeID)) {
            return $this->respond([
                'success' => false,
                'message' => 'Missing required loan application data.'
            ], ResponseInterface::HTTP_BAD_REQUEST);
        }

        $memberNo = $json->memberNumber;
        $principal = floatval($json->principal);
        $repaymentPeriod = intval($json->repaymentPeriod);
        $loanTypeID = intval($json->loanTypeID);

        // Get member
        $memberModel = new MembersModel();
        $member = $memberModel->where('member_number', $memberNo)->first();

        if (!$member) {
            return $this->respond([
                'success' => false,
                'message' => 'Member not found.'
            ], ResponseInterface::HTTP_NOT_FOUND);
        }

        $loanTypeModel = new \App\Models\LoanTypeModel();
        $loanType = $loanTypeModel->find($loanTypeID);

        if (!$loanType) {
            return $this->respond([
                'success' => false,
                'message' => 'Invalid loan type.'
            ], ResponseInterface::HTTP_NOT_FOUND);
        }

        $interestRate = floatval($loanType['interest_rate']) / 100;
        $interestType = $loanType['interest_type_id']; // 1 = Flat, 2 = Reducing
        $insurancePremiumRate = floatval($loanType['insurance_premium']) / 100;
        $serviceChargeRate = floatval($loanType['service_charge']) / 100;
        $crbAmount = floatval($loanType['crb_amount']);

        $insurancePremium = $principal * $insurancePremiumRate;
        $serviceCharge = $principal * $serviceChargeRate;
        $fees = $serviceCharge + $insurancePremium + $crbAmount;
        $disburseAmount = $principal - $fees;

        // Loan interest and repayment calculations
        $interest = 0;
        $repayment = 0;
        $totalLoan = 0;

        if ($interestType == 1) { // Flat Rate
            $interest = $principal * $interestRate * $repaymentPeriod;
            $totalLoan = $principal + $interest;
            $repayment = $totalLoan / $repaymentPeriod;
        } elseif ($interestType == 2) { // Reducing Balance
            $r = $interestRate;
            $n = $repaymentPeriod;
            $P = $principal;

            if ($r > 0 && $n > 0) {
                $repayment = ($P * $r * pow(1 + $r, $n)) / (pow(1 + $r, $n) - 1);
            }
            $totalLoan = round($repayment * $n, 0);
            $interest = round($totalLoan - $P, 0);
        }

        // Return calculated data
        return $this->respond([
            'success' => true,
            'message' => 'Loan application calculations completed.',
            'data' => [
                'principal' => $principal,
                'repayment_period' => $repaymentPeriod,
                'interest' => round($interest, 2),
                'total_loan' => round($totalLoan, 2),
                'monthly_repayment' => round($repayment, 2),
                'insurance_premium' => round($insurancePremium, 2),
                'service_charge' => round($serviceCharge, 2),
                'crb_amount' => round($crbAmount, 2),
                'total_fees' => round($fees, 2),
                'disburse_amount' => round($disburseAmount, 2)
            ]
        ], ResponseInterface::HTTP_OK);
    }

    public function apply()
    {
        $data = $this->request->getJSON(true);

        // Validate basic fields
        if (!isset($data['memberNumber'], $data['loanTypeID'], $data['principal'], $data['repaymentPeriod'])) {
            return $this->respond([
                'success' => false,
                'message' => 'Missing required loan application data.'
            ], ResponseInterface::HTTP_BAD_REQUEST);
        }

        $loanTypeModel = new LoanTypeModel();
        $loanApplicationModel = new LoanApplicationModel();
        $membersModel = new MembersModel();
        
        $member = $membersModel->where('member_number', $data['memberNumber'])->first();

        // 1. Fetch loan type details (interest rate, method, charges)
        $loanType = $loanTypeModel->find($data['loanTypeID']);
        if (!$loanType) return $this->failNotFound('Invalid loan type');

        $interestRate = $loanType['interest_rate'];
        $methodId = $loanType['interest_type_id'];

        $interestModel = new InterestTypeModel();
        $methodArr = $interestModel->find($methodId);
        $method = $methodArr['name'];

        // 2. Do backend calculations
        $principal = (float)$data['principal'];
        $period = (int)$data['repaymentPeriod'];
        $rate = $interestRate / 100;

        if ($method === 'reducing_balance') {
            // EMI formula
            $monthlyRate = $rate / 12;
            $emi = ($principal * $monthlyRate * pow(1 + $monthlyRate, $period)) / (pow(1 + $monthlyRate, $period) - 1);
            $totalRepayment = $emi * $period;
        } else {
            // Flat interest method
            $totalInterest = $principal * $rate * ($period / 12);
            $totalRepayment = $principal + $totalInterest;
            $emi = $totalRepayment / $period;
        }

        // Additional charges
        $fees = ($loanType['service_charge'] ?? 0) + ($loanType['insurance_premium'] ?? 0) + ($loanType['crb_amount'] ?? 0);
        $disburseAmount = $principal - $fees;

        // 3. Prepare final loan application data
        $loanData = [
            'member_id'         => $member['id'],
            'loan_type_id'      => $data['loan_type_id'],
            'principal'         => $principal,
            'repayment_period'  => $period,
            'interest_method'   => $method,
            'interest_rate'     => $interestRate,
            'fees'              => $fees,
            'monthly_repayment' => round($emi, 2),
            'total_loan'        => round($totalRepayment, 2),
            'total_interest'    => round($totalRepayment - $principal, 2),
            'disburse_amount'   => round($disburseAmount, 2),
            'loan_status'       => 'pending',
            'request_date'      => date('Y-m-d'),
            'created_at'        => date('Y-m-d H:i:s')
        ];

        // 4. Save to DB
        $loanApplicationModel->insert($loanData);

        return $this->respondCreated([
            'message' => 'Loan application submitted successfully.',
            'loan_id' => $loanApplicationModel->getInsertID(),
        ]);
    }
}
