<?php

namespace App\Controllers;

use App\Models\MembersModel;
use App\Models\UserModel;
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
        if (! $this->request->is('post')) {
            return view('/members');
        }

        // save the user
        $fname = $this->request->getPost('first-name');
        $lname = $this->request->getPost('last-name');
        $mobile = $this->request->getPost('mobile');

        $data = [
            'member_name'=> $fname . ' ' . $lname,
            'member_phone'=> $mobile,
        ];


        // storing data
        $memberModel = new \App\Models\MembersModel();
        $query = $memberModel->save($data);
        if (! $query) {
            return redirect()->back()->with('fail', 'Saving User failed');
        } 
        else
        {
            
            return redirect()->back()->with('Success', 'Saved User');
        }

    }

}
