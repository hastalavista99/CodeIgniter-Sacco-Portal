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
            return view('auth/register');
        }
        $validated = [
            'name'=> 'required',
            'email'=> 'required|valid_email',
            'password'=> 'required|min_length[5]|max_length[20]',
            'passwordConf'=> 'required|min_length[5]|max_length[20]|matches[password]'
        ]; 
        $data = $this->request->getPost(array_keys($validated));

        if (! $this->validateData($data, $validated)) {
            return view('auth/register');
        }
        $validData = $this->validator->getValidated();

        // save the user
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $passwordConf = $this->request->getPost('passwordConf');

        new \App\Libraries\Hash();
        $data = [
            'name'=> $name,
            'email'=> $email,
            'password'=> Hash::encrypt($password)
        ];


        // storing data
        $userModel = new \App\Models\UserModel();
        $query = $userModel->save($data);
        if (! $query) {
            return redirect()->back()->with('fail', 'Saving User failed');
        } 
        else
        {
            return redirect()->back()->with('Success', 'Saved User');
        }

    }

}
