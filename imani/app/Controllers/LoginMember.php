<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MemberLogin;
use App\Models\UserModel;
use App\Libraries\Hash;
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
            'users' => $userModel->orderBy('id', 'DESC')->findAll(),
            'userInfo' => $userInfo,
        ];
        return view('users/index', $data);
    }

    public function profile()
    {
        helper('form');
        $model = new MemberLogin();
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $data = [
            'title' => 'Profile',
            'users' => $model->orderBy('auth_id', 'DESC')->findAll(),
            'userInfo' => $userInfo,
        ];
        return view('users/profile', $data);
    }

    public function changePass()
    {
        helper(['form', 'url']);

        // Validation rules
        $rules = [
            'password' => 'required',
            'newpassword' => 'required|min_length[5]|max_length[20]',
            'renewpassword' => 'required|matches[newpassword]'
        ];

        // Validate the input
        if (!$this->validate($rules)) {
            return view('/profile', [
                'validation' => $this->validator
            ]);
        }

        $id = $this->request->getGet('id');
        $currentPass = $this->request->getPost('password');
        $newPass = $this->request->getPost('newpassword');

        // Load user model
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->back()->with('fail', 'User not found.');
        }

        // Verify current password
        if (!Hash::check($currentPass, $user['password'])) {
            return redirect()->to('/profile')->with('fail', 'Incorrect current password.');
        }

        // Hash new password
        $data = [
            'password' => Hash::encrypt($newPass),
        ];

        // Update password
        if ($userModel->update($id, $data)) {
            return redirect()->to('/profile')->with('success', 'Password updated successfully.');
        } else {
            return redirect()->back()->withInput()->with('fail', 'Failed to update password.');
        }
    }

    public function newUser()
    {
        helper('form');
        // validate user input
        if (!$this->request->is('post')) {
            return view('/users');
        }

        // save the user
        $name = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $mobile = $this->request->getPost('mobile');
        $password = $this->request->getPost('password');
        $role = $this->request->getPost('role');

        $data = [
            'name' => $name,
            'email' => $email,
            'mobile' => $mobile,
            'password' => Hash::encrypt($password),
            'role' => $role,
        ];


        // storing data
        $userModel = new \App\Models\UserModel();
        $query = $userModel->save($data);
        if (!$query) {
            return redirect()->back()->with('fail', 'Saving User failed');
        }


        return redirect()->back()->with('success', 'Saved User');
    }

    public function sms()
    {
    }
}
