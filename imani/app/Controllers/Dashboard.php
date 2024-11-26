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

        // Check if member_no exists and is not empty
        $hasMemberNo = !empty($userInfo['member_no']);

        if ($hasMemberNo) {
            $balance = $balancesModel
                ->where('member_no', $userInfo['member_no'])
                ->first();

            $payments = $paymentsModel
                ->where('SUBSTRING(BillRefNumber, -10) =', $userInfo['mobile'])
                ->orderBy('mp_date', 'DESC')
                ->findAll(5);
        } else {
            $balance = null;
            $payments = [];
        }

        $data = [
            'title' => 'Dashboard',
            'userInfo' => $userInfo,
            'balance' => $balance,
            'payments' => $payments,
            'hasMemberNo' => $hasMemberNo
        ];
        return view('dashboard/index', $data);
    }

    // save the member number from the dashboard modal
    public function updateMemberNo()
    {
        if ($this->request->isAJAX()) {
            $memberNo = strtoupper($this->request->getPost('member_no'));
            $loggedInUserId = session()->get('loggedInUser');

            $userModel = new UserModel();

            try {
                $userModel->update($loggedInUserId, ['member_no' => $memberNo]);
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Member number updated successfully'
                ]);
            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to update member number'
                ]);
            }
        }
    }
}
