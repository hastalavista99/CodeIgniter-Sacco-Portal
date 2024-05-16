<?php

namespace App\Controllers;

use App\Models\MembersModel;
use App\Models\UserModel;
use App\Libraries\Hash;
use App\Controllers\SendSMS;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;

class Members extends BaseController
{
    public function index()
    {
        $model = model(MembersModel::class);
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $data = [
            'members'  => $model->getMembers(),
            'title' => 'Members',
            'userInfo' => $userInfo,
        ];

        return view('members/index', $data);
    }

    public function show()
    {
        $model = model(MembersModel::class);

        $data['members'] = $model->getMembers();

        if (empty($data['members'])) {
            throw new PageNotFoundException('Cannot find the news item: ');
        }

        $data['title'] = $data['members'];

        return view('templates/header', $data)
            . view('members/view')
            . view('templates/footer');
    }

    public function newMember()
    {
        helper('form');
        // validate user input
        if (!$this->request->is('post')) {
            return view('/members');
        }

        // save the user
        $fname = $this->request->getPost('first-name');
        $lname = $this->request->getPost('last-name');
        $mobile = $this->request->getPost('mobile');

        $data = [
            'member_name' => $fname . ' ' . $lname,
            'member_phone' => $mobile,
        ];


        // storing data
        $memberModel = new \App\Models\MembersModel();
        $query = $memberModel->save($data);
        if (!$query) {
            return redirect()->back()->with('fail', 'Saving User failed');
        }


        $alpha_numeric = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $pass = substr(str_shuffle($alpha_numeric), 0, 8);

        $createUser = new \App\Models\UserModel();
        new \App\Libraries\Hash();

        $data = [
            'name' => $fname,
            'email' => '',
            'mobile' => $mobile,
            'password' => Hash::encrypt($pass),
            'role' => 'member',
        ];
        $insert = $createUser->save($data);
        if (!$insert) {
            return redirect()->back()->with('fail', 'Saving User failed');
        } else {
            $msg = "Hi, $fname \n Welcome to Pula Sacco Login to https://sacco.pulasacco.co.ke to view your transactions.\nUsername: $fname\nPassword: $pass; \n Regards \n Pula Sacco Manager";

            $sms = new SendSMS();

           $sms->sendSMS($mobile, $msg);
            }
            return redirect()->back()->with('Success', 'Saved User');
        
    }

    public function editMember()
    {
        helper('form');
        $model = model(MembersModel::class);
        $userModel = model(UserModel::class);
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);
        $data = [
            'members'  => $model->getMembers(),
            'title' => 'Members',
            'userInfo' => $userInfo,
        ];
        return view('members/edit', $data);
    }

}
