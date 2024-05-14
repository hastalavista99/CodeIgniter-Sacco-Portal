<?php

namespace App\Controllers;

use App\Models\PaymentsModel;
use App\Models\UserModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;

class Payments extends BaseController
{
    public function index()
    {
        $model = model(PaymentsModel::class);
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $data = [
            'payments'  => $model->getPayments(),
            'title' => 'Payments',
            'userInfo' => $userInfo,
        ];

        return view('payments/index', $data);

    }

    public function show()
    {
        $model = model(PaymentsModel::class);

        $data['payments'] = $model->getPayments();

        if (empty($data['payments'])) {
            throw new PageNotFoundException('Cannot find any payments: ');
        }

        $data['title'] = $data['payments'];

        return view('payments/index', $data);
    }
}
