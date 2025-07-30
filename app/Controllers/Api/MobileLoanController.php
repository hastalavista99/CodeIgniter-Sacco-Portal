<?php

namespace App\Controllers\Api;

use App\Models\MembersModel;
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

        $memberNumber = $request->memberNumber;
        $amount = floatval($request->loan_amount);

        $memberModel = new MembersModel();
        $member = $memberModel->where('member_number', $memberNumber)->first();

        $memberId = $member ? $member['id'] : null;

        // For this prototype, simulate calculations
        $interestRate = 8;
        $interest = $amount * ($interestRate / 100);
        $totalRepayable = $amount + $interest;

        // Save to DB (fake for now — log only)
        log_message('info', "Mobile Loan Requested: Member {$memberId} | Amount: {$amount} | Total: {$totalRepayable}");

        // Example future save: $this->mobileLoanModel->insert([...]);

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
                'disbursement_method' => 'mpesa_b2c'
            ]
        ]);
    }
}
