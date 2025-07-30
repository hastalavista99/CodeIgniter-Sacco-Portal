<?php

namespace App\Controllers\Api;

use App\Models\MembersModel;
use App\Models\MobileLoanModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class MobileLoanController extends ResourceController
{
    protected $format = 'json';

    public function settings()
    {
        return $this->respond([
            'status' => 200,
            'error' => false,
            'message' => 'Mobile loan settings retrieved successfully',
            'interest_rate' => 8,
            'repayment_days' => 30
        ], ResponseInterface::HTTP_OK);
    }

    public function request()
    {
        $request = $this->request->getJSON();

        if (!isset($request->memberNumber, $request->loan_amount)) {
            return $this->failValidationErrors("Missing required parameters.");
        }

        $memberNumber = trim($request->memberNumber);
        $amount = floatval($request->loan_amount);

        $memberModel = new \App\Models\MembersModel();
        $member = $memberModel->where('member_number', $memberNumber)->first();

        if (!$member) {
            return $this->failNotFound("Member not found.");
        }

        $memberId = $member['id'];

        // Simulate calculations
        $interestRate = 8.0;
        $interest = $amount * ($interestRate / 100);
        $totalRepayable = $amount + $interest;

        // Calculate repayment due date (30 days from now)
        $repaymentDueDate = date('Y-m-d', strtotime('+30 days'));

        // Save loan application
        $loanModel = new \App\Models\MobileLoanModel();
        $loanModel->insert([
            'member_id' => $memberId,
            'amount' => $amount,
            'interest_rate' => $interestRate,
            'total_repayable' => $totalRepayable,
            'repayment_due_date' => $repaymentDueDate,
            'disbursement_status' => 'pending',
        ]);

        return $this->respondCreated([
            'status' => 201,
            'error' => false,
            'message' => 'Loan application submitted successfully',
            'data' => [
                'member_id' => $memberId,
                'loan_amount' => $amount,
                'interest' => $interest,
                'total_repayable' => $totalRepayable,
                'repayment_days' => 30,
                'repayment_due_date' => $repaymentDueDate,
                'disbursement_method' => 'mpesa_b2c',
                'disbursement_status' => 'pending',
            ]
        ]);
    }

    public function fetchLoan($memberNo)
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

        $loanModel = new MobileLoanModel();
        $loans = $loanModel->getMemberDetails($member['id']);

        return $this->response->setJSON([
            'status' => ResponseInterface::HTTP_OK,
            'error' => false,
            'message' => 'Transactions retrieved successfully',
            'data' => $loans
        ])->setStatusCode(ResponseInterface::HTTP_OK);
    }
}
