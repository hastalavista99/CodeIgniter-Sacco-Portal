<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Accounting\TransactionsModel;
use App\Models\LoanApplicationModel;
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
}
