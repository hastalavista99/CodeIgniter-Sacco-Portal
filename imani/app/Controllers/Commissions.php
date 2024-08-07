<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CommissionsModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class Commissions extends BaseController
{
    public function index()
    {
        helper('form');

        $model = new CommissionsModel();
        $commissions = $model->findAll();

        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);
            $data = [
                'title' => 'Commissions',
                'commissions' => $commissions,
                'userInfo' => $userInfo

            ];

        return view('agents/commission', $data);
    }
    public function individual()
    {
        helper('form');
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);
        $userMobile = $userInfo['mobile'];
        $model = new CommissionsModel();
        $commissions = $model->where('member_phone', $userMobile)->findAll();
            $data = [
                'title' => 'Commissions',
                'commissions' => $commissions,
                'userInfo' => $userInfo

            ];

        return view('agents/commission', $data);
    }
}
