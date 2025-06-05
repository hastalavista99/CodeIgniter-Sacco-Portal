<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Hash;
use App\Models\UserModel;
use App\Models\StaffModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Helpers\generateStaffQrCode;
use App\Models\OrganizationModel;

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
        $photo->move(FCPATH . 'public/uploads/staff/', $photoName);

        // Optionally create user account
        $createUser = $this->request->getPost('create_user');
        $userId = null;

        if ($createUser === 'yes') {
            $userId = $userModel->insert([
                'user' => $this->request->getPost('first_name') . ' ' . $this->request->getPost('last_name'),
                'name' => $this->request->getPost('email'),
                'email' => $this->request->getPost('email'),
                'mobile' => $this->request->getPost('phone'),
                'password' => Hash::encrypt($this->request->getPost('password')),
                'role' => 'staff',
            ]);

            $sms = new SendSMS();
            $mobile= $this->request->getPost('phone');
            $msg = "Welcome " . $this->request->getPost('first_name') . ", your account has been created successfully. Your login details are: Username: " . $this->request->getPost('email') . ", Password: " . $this->request->getPost('password');

            $sms->sendSMS($mobile, $msg);
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

    public function view($id)
    {
        $staffModel = new StaffModel();
        $userModel = new UserModel();
        $loggedInUser = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUser);

        $staffMember = $staffModel->find($id);
        if (!$staffMember) {
            return redirect()->to('/staff')->with('error', 'Staff member not found.');
        }

        $data = [
            'title' => 'Staff Profile: ' . $staffMember['first_name'] . ' ' . $staffMember['last_name'],
            'userInfo' => $userInfo,
            'staff' => $staffMember,
        ];
        return view('staff/view', $data);
    }

    public function edit($id)
    {
        $staffModel = new StaffModel();
        $userModel = new UserModel();
        $loggedInUser = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUser);

        $staffMember = $staffModel->find($id);
        if (!$staffMember) {
            return redirect()->to('/staff')->with('error', 'Staff member not found.');
        }

        $data = [
            'title' => 'Edit Staff Member: ' . $staffMember['first_name'] . ' ' . $staffMember['last_name'],
            'userInfo' => $userInfo,
            'staff' => $staffMember,
        ];
        return view('staff/edit', $data);
    }

    public function update($id)
    {
        helper(['form', 'url']);

        $staffModel = new StaffModel();
        $userModel = new UserModel();

        $staffMember = $staffModel->find($id);
        if (!$staffMember) {
            return redirect()->to('/staff')->with('error', 'Staff member not found.');
        }

        $validationRules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|valid_email',
            'phone' => 'required',
            'photo' => 'if_exist|is_image[photo]|max_size[photo,2048]',
        ];

        // Ignore unique validation if email/phone is unchanged
        if ($this->request->getPost('email') !== $staffMember['email']) {
            $validationRules['email'] .= '|is_unique[staff.email]';
        }
        if ($this->request->getPost('phone') !== $staffMember['phone']) {
            $validationRules['phone'] .= '|is_unique[staff.phone]';
        }

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $photo = $this->request->getFile('photo');
        $photoName = $staffMember['photo'];
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            $photoName = $photo->getRandomName();
            $photo->move(FCPATH . 'public/uploads/staff/', $photoName);
            // Optionally delete old photo
            if ($staffMember['photo'] && file_exists(FCPATH . 'public/uploads/staff/' . $staffMember['photo'])) {
                @unlink(FCPATH . 'public/uploads/staff/' . $staffMember['photo']);
            }
        }

        $staffModel->update($id, [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'gender' => $this->request->getPost('gender'),
            'position' => $this->request->getPost('position'),
            'department' => $this->request->getPost('department'),
            'hire_date' => $this->request->getPost('hire_date'),
            'status' => $this->request->getPost('status'),
            'photo' => $photoName,
        ]);

        // Optionally update linked user account
        if ($staffMember['user_id']) {
            $userModel->update($staffMember['user_id'], [
                'user' => $this->request->getPost('first_name') . ' ' . $this->request->getPost('last_name'),
                'name' => $this->request->getPost('email'),
                'email' => $this->request->getPost('email'),
                'mobile' => $this->request->getPost('phone'),
            ]);
        }

        return redirect()->to('/staff')->with('success', 'Staff member updated successfully.');
    }

    public function badge($id)
    {
        $orgModel = new OrganizationModel();
        $organization = $orgModel->first();
        $staffModel = new StaffModel();
        $staff = $staffModel->find($id);

        if (!$staff) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Staff member not found.");
        }

        // Generate QR code
        $qrContent = "Staff ID: {$staff['staff_number']}\nName: {$staff['first_name']} {$staff['last_name']}\nPosition: {$staff['position']}";
        $qrPath = generateStaffQrCode($qrContent, $staff['staff_number'] . '.png');

        return view('staff/badge', [
            'staff' => $staff,
            'qrPath' => $qrPath,
            'organization' => $organization,
        ]);
    }

}
