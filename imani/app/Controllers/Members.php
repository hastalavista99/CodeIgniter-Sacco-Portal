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
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Members extends BaseController
{
    public function index()
    {
        $model = model(MembersModel::class);
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $data = [
            'members'  => $model->findAll(),
            'title' => 'Members',
            'userInfo' => $userInfo,
        ];

        return view('members/index', $data);
    }


    public function create()
    {
        log_message('debug', 'Request method received: ' . $this->request->getMethod());

        // Handle form submission
        if ($this->request->getMethod() !== 'POST') {
            return $this->response->setStatusCode(405)->setJSON([
                'success' => false,
                'message' => 'Invalid request method'
            ]);
        }

        // Handle file upload first
        $photoPath = null;
        $photo = $this->request->getFile('photo');
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            $newName = $photo->getRandomName();
            $photo->move(WRITEPATH . 'uploads', $newName);
            $photoPath = 'uploads/' . $newName;
        }

        // Prepare member data
        $memberData = [
            'member_number' => $this->request->getPost('memberNumber'),
            'first_name' => $this->request->getPost('firstName'),
            'last_name' => $this->request->getPost('lastName'),
            'dob' => $this->request->getPost('dob'),
            'join_date' => $this->request->getPost('joinDate'),
            'gender' => $this->request->getPost('gender'),
            'nationality' => $this->request->getPost('nationality'),
            'marital_status' => $this->request->getPost('maritalStatus'),
            'id_number' => $this->request->getPost('idNumber'),
            'terms_accepted' => $this->request->getPost('termsAccepted'),
            'email' => $this->request->getPost('email'),
            'phone_number' => $this->request->getPost('phoneNumber'),
            'alternate_phone' => $this->request->getPost('alternatePhone'),
            'street_address' => $this->request->getPost('streetAddress'),
            'address_line2' => $this->request->getPost('addressLine2'),
            'city' => $this->request->getPost('city'),
            'county' => $this->request->getPost('county'),
            'zip_code' => $this->request->getPost('zipCode'),
            'photo_path' => $photoPath,
        ];

        // Prepare beneficiary data
        $beneficiaryData = [
            'first_name' => $this->request->getPost('beneficiaryFirstName'),
            'last_name' => $this->request->getPost('beneficiaryLastName'),
            'dob' => $this->request->getPost('beneficiaryDOB'),
            'phone_number' => $this->request->getPost('beneficiaryPhone'),
            'relationship' => $this->request->getPost('beneficiaryRelationship'),
            'is_beneficiary' => $this->request->getPost('isBeneficiary'),
            'entitlement_percentage' => $this->request->getPost('entitlementPercentage'),
        ];

        $model = new MembersModel();

        // Validate and save
        if (!$model->validate($memberData)) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $model->errors()
            ]);
        }

        $memberId = $model->insertMemberWithBeneficiary($memberData, $beneficiaryData);

        if ($memberId) {
            return $this->response->setStatusCode(201)->setJSON([
                'success' => true,
                'message' => 'Member created successfully',
                'member_id' => $memberId
            ]);
        } else {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Failed to create member'
            ]);
        }
    }

    public function new()
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

    public function getMember($memberNo)
    {
        $model = new MembersModel();
        $member = $model->where('member_number', $memberNo)->first();

        if ($member) {
            return $this->response->setJSON([
                'name' => $member['first_name'] ." ".  $member['last_name'],
                'mobile' => $member['phone_number']
            ]);
        }

        return $this->response->setJSON(['error' => 'Member not found'])->setStatusCode(404);
    }
}
