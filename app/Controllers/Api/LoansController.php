<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Accounting\TransactionsModel;
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

    public function mobileLoanApplication()
    {

    }

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
    public function loanApplication()
    {
        $json = $this->request->getJSON();

        // Validate presence of data
        if (!isset($json->memberNo) || !isset($json->amountRequested) || !isset($json->tenureDays)) {
            return $this->respond([
                'success' => false,
                'message' => 'Member number, amount requested, and tenure days are required'
            ], ResponseInterface::HTTP_BAD_REQUEST);
        }

        $memberNo = $json->memberNumber;
        $amountRequested = $json->principal;
        $tenureDays = $json->repaymentPeriod;
        $loanType = $json->loanType;

        $memberModel = new MembersModel();
        $member = $memberModel->where('member_number', $memberNo)->first();
        $memberId = $member['id'];


        

        return $this->respond([
            'success' => true,
            'message' => 'Loan application submitted successfully'
        ], ResponseInterface::HTTP_CREATED);
    }

}
