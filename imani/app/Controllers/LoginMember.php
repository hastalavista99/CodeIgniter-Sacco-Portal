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

    public function userDetails()
    {
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $data = [
            
            'userInfo' => $userInfo,
        ];

        return $data;
    }

    public function profile()
    {
        helper('form');
        $model = new MemberLogin();
        $data = LoginMember::userDetails();

        $data['title'] = 'Profile';
        $data['users'] = $model->orderBy('auth_id', 'DESC')->findAll();
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

        $data = $this->request->getPost(array_keys($rules));

        // Validate the input
        // if (!$this->validateData($data, $rules)) {
        //     return redirect()->to('/profile')->with('validation', $this->validator);
            
        // }

        $id = $this->request->getGet('id');
        $currentPass = $this->request->getPost('password');
        $newPass = $this->request->getPost('newpassword');

        // Load user model
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->back()->with('fail', 'User not found.');
        }

        $checkPassword = Hash::check($currentPass, $user['password']);
        // Verify current password
        if (!$checkPassword) {
            return redirect()->to('/profile')->with('fail', 'Incorrect current password.');
        }

        // Hash new password
        $data = [
            'password' => Hash::encrypt($newPass),
        ];

        // Update password
        if ($userModel->update($id, $data)) {
            log_message('success', 'Password change success. User:'.$user['name']. ' UserID:'.$id);
            return redirect()->to('/profile')->with('success', 'Password updated successfully.');
        } else {
            log_message('error', 'Failed to update password. User:'.$user['name']. ' UserID:'.$id);
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
        $permissions = $this->request->getPost('permissions');

        $data = [
            'name' => $name,
            'email' => $email,
            'mobile' => $mobile,
            'password' => Hash::encrypt($password),
            'role' => $role,
            'permissions' => $permissions ? json_encode($permissions) : null
        ];


        // storing data
        $userModel = new \App\Models\UserModel();
        $query = $userModel->save($data);
        if (!$query) {
            return redirect()->back()->with('fail', 'Saving User failed');
        }


        return redirect()->back()->with('success', 'Saved User');
    }

}
