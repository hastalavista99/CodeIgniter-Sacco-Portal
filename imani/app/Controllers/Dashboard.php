<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{

    public function userDetails()
    {
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $data = [
            'title' => 'Dashboard',
            'userInfo' => $userInfo,
        ];

        return $data;
    }
    public function index()
    {

        $data = Dashboard::userDetails();

        return view('dashboard/index', $data);
    }
}
