<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class Pages extends BaseController
{

    public function unauthorized()
    {
        $userModel = model(UserModel::class);
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);
        return view('errors/unauthorized', [
            'title' => 'Access Denied',
            'userInfo' => $userInfo
        ]);
    }
}
