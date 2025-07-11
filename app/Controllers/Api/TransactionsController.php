<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Accounting\TransactionsModel;
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
}
