<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MemberLogin;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class LoginMember extends BaseController
{
    public function index()
    {
        $model = new MemberLogin();
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $data = [
            'title' => 'Users',
            'users' => $model->orderBy('auth_id', 'DESC')->findAll(),
            'userInfo' => $userInfo,
        ];
        return view('users/index', $data);
    }

    
}
