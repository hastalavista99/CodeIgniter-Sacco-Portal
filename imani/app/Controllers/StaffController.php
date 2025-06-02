<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\StaffModel;
use CodeIgniter\HTTP\ResponseInterface;

class StaffController extends BaseController
{
    public function index()
    {
        $staffModel = new StaffModel();
        $userModel = new UserModel();
        $loggedInUser = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUser);

        $data = [
            'title' => 'Staff Members',
            'userInfo' => $userInfo,
            'staffMembers' => $staffModel->findAll(),
        ];
        return view('staff/index', $data);
        
    }

    public function create()
    {
        $userModel = new UserModel();
        $loggedInUser = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUser);

        $data = [
            'title' => 'Add Staff Member',
            'userInfo' => $userInfo,
        ];
        return view('staff/create', $data);
    }

    public function store()
    {
        helper(['form', 'url']);

        $staffModel = new StaffModel();
        $userModel = new UserModel();

        $validationRules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|valid_email|is_unique[staff.email]',
            'phone' => 'required|is_unique[staff.phone]',
            'photo' => 'uploaded[photo]|is_image[photo]|max_size[photo,2048]',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Upload profile photo
        $photo = $this->request->getFile('photo');
        $photoName = $photo->getRandomName();
        $photo->move(WRITEPATH . 'uploads/staff/', $photoName);

        // Optionally create user account
        $createUser = $this->request->getPost('create_user');
        $userId = null;

        if ($createUser === 'yes') {
            $userId = $userModel->insert([
                'username' => $this->request->getPost('email'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'role' => 'staff',
            ]);
        }

        $staffModel->insert([
            'staff_number' => 'ST' . time(),
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'gender' => $this->request->getPost('gender'),
            'position' => $this->request->getPost('position'),
            'department' => $this->request->getPost('department'),
            'hire_date' => $this->request->getPost('hire_date'),
            'status' => 'active',
            'photo' => $photoName,
            'user_id' => $userId,
        ]);

        return redirect()->to('/staff')->with('success', 'Staff member added successfully.');
    }
}
