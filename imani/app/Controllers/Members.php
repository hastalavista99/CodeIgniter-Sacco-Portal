<?php

namespace App\Controllers;

use App\Models\MembersModel;
use App\Models\PaymentsModel;
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
        $memberNumber = $this->request->getPost('memberNumber');

        $data = [
            'member_name' => $fname . ' ' . $lname,
            'member_phone' => $mobile,
            'member_number' => $memberNumber
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
            $msg = "Hi, $fname \n Welcome to Gloha Sacco Login to https://app.gloha-sacco.co.ke to view your transactions.\nUsername: $fname\nPassword: $pass; \n Regards \n Gloha Sacco Manager";

            $sms = new SendSMS();

            $sms->sendSMS($mobile, $msg);
        }
        return redirect()->back()->with('Success', 'Saved User');
    }

    public function editMember()
    {
        helper('form');
        $id = $this->request->getGet('id');
        $model = model(MembersModel::class);
        $userModel = model(UserModel::class);
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);
        $member = $model->find($id);
        $data = [
            'member'  => $member,
            'title' => 'Edit Member',
            'userInfo' => $userInfo,
            'id' => $id
        ];
        return view('members/edit', $data);
    }

    public function updateMember()
    {
        helper(['form', 'url']);
        $id = $this->request->getGet('id');
        $name = $this->request->getPost('name');
        $mobile = $this->request->getPost('mobile');
        $memberNumber = $this->request->getPost('memberNumber');
        $data = [
            'member_name' => $name,
            'member_phone' => $mobile,
            'member_number' => $memberNumber
        ];

        $model = model(MembersModel::class);

        if ($model->update($id, $data)) {
            // Update successful
            return redirect()->to('/members')->with('success', 'Member updated successfully.');
        } else {
            // Update failed
            return redirect()->back()->withInput()->with('fail', 'Failed to update member.');
        }
    }

    public function deleteMember()
    {
        helper(['form', 'url']);

        $id = $this->request->getGet('id');
        $model = model(MembersModel::class);
        $paymentModel = new PaymentsModel();

        // Check if member exists
        $member = $model->find($id);
        if (!$member) {
            return redirect()->to('/members')->with('fail', 'Member not found.');
        }

        // Check if member has transactions
        $transactions = $paymentModel->where('MSISDN', $member['member_phone'])->findAll();
        if ($transactions) {
            return redirect()->to('/members')->with('fail', 'Failed! Member has transactions.');
        }

        // Delete member
        if ($model->delete($id)) {
            return redirect()->to('/members')->with('success', 'Member deleted successfully.');
        } else {
            return redirect()->to('/members')->with('fail', 'Failed to delete member.');
        }
    }

    public function createPage()
    {
        helper('form');

        $userModel = model(UserModel::class);
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $data = [
            'title' => 'Create Member',
            'userInfo' => $userInfo
        ];

        return view('members/create', $data);
    }
}
