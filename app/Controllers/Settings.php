<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BalancesModel;
use App\Models\PaymentsModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class Settings extends BaseController
{
    public function index()
    {
        $balancesModel = new BalancesModel();
        $paymentsModel = new PaymentsModel();
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $data = [
            'title' => 'System Settings',
            'userInfo' => $userInfo,

        ];
        return view('settings', $data);
    }

    public function closeMonth()
    {
        $currentPeriod = date('Y-m', strtotime(get_system_date()));
        $lastClosed = get_system_parameter('last_closed_period');

        if ($lastClosed && $currentPeriod <= $lastClosed) {
            return redirect()->back()->with('error', 'This period is already closed or before the last closed period.');
        }

        // Optional: Run calculations like interest, dividend accrual, etc.

        // Update system parameter
        $model = new \App\Models\SystemParameterModel();
        $model->where('param_key', 'last_closed_period')
            ->set(['param_value' => $currentPeriod])
            ->update();

        return redirect()->back()->with('success', 'Month closed successfully: ' . $currentPeriod);
    }


}
