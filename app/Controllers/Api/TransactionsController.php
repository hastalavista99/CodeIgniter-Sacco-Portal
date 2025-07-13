<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Accounting\SavingsAccountModel;
use App\Models\Accounting\SharesAccountModel;
use App\Models\Accounting\TransactionsModel;
use App\Models\LoanApplicationModel;
use App\Models\MembersModel;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use CodeIgniter\HTTP\ResponseInterface;

class TransactionsController extends BaseController
{
    use ResponseTrait;

    protected $model;

    public function __construct()
    {
        $this->model = new TransactionsModel();
    }

    public function index($member)
    {
        $model = new TransactionsModel();
        $transactions = $model->getMobileTransactions($member,10);

        if (empty($transactions)) {
            return $this->response->setJSON([
                'status' => ResponseInterface::HTTP_NOT_FOUND,
                'error'  => true,
                'message' => 'No transactions found',
                'data' => []
            ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        return $this->response->setJSON([
            'status'  => ResponseInterface::HTTP_OK,
            'error'   => false,
            'message' => 'Transactions retrieved successfully',
            'data'    => $transactions
        ])->setStatusCode(ResponseInterface::HTTP_OK);
    }

    public function balances($memberNo) 
    {
        $memberModel = new MembersModel();
        $member = $memberModel->where('member_number', $memberNo)->first();
        $id = $member['id'];

        $savingsModel = new SavingsAccountModel();
        $sharesModel = new SharesAccountModel();
        $loanModel = new LoanApplicationModel();

        $savings = $savingsModel->getMemberSavingsTotal($id);
        $shares = $sharesModel->getMemberSharesTotal($id);
        $loans = $loanModel->getMemberLoanSummary($id);
        

        if (empty($memberNo)) {
            return $this->response->setJSON([
                'status' => ResponseInterface::HTTP_NOT_FOUND,
                'error'  => true,
                'message' => 'No transactions found',
                'data' => []
            ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        return $this->response->setJSON([
            'status'  => ResponseInterface::HTTP_OK,
            'error'   => false,
            'message' => 'Transactions retrieved successfully',
            'data'    => [
                'savingsBalance' => $savings,
                'sharesBalance' => $shares,
                'loanBalance' => round($loans[0]['balance'], 2)
            ]
        ])->setStatusCode(ResponseInterface::HTTP_OK);
    }
}
