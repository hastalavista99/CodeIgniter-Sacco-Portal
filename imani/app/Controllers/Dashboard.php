<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BalancesModel;
use App\Models\PaymentsModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{

    public function index()
    {
        $balancesModel = new BalancesModel();
        $paymentsModel = new PaymentsModel();
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);
        $balance = $balancesModel
                    ->where('member_no', $userInfo['member_no'])
                    ->first();
        $payments = $paymentsModel
                    ->where('SUBSTRING(BillRefNumber, -10) =', $userInfo['mobile'])
                    ->orderBy('mp_date', 'DESC')
                    ->findAll(5);

        $data = [
            'title' => 'Dashboard',
            'userInfo' => $userInfo,
            'balance' => $balance,
            'payments' => $payments
        ];

        return view('dashboard/index', $data);
    }
}
