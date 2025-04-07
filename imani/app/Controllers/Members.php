<?php

namespace App\Controllers;

use App\Models\MembersModel;
use App\Models\PaymentsModel;
use App\Models\UserModel;
use App\Libraries\Hash;
use App\Controllers\SendSMS;
use App\Controllers\BaseController;
use App\Models\BeneficiaryModel;
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

        $benFirstName = $this->request->getPost('beneficiaryFirstName');
        if (isset($benFirstName)) {
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
        }

        $model = new MembersModel();

        // Validate and save
        if (!$model->validate($memberData)) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $model->errors()
            ]);
        }

        if (isset($benFirstName)) {
            $memberId = $model->insertMemberWithBeneficiary($memberData, $beneficiaryData);
        } else {
            $memberId = $model->insert($memberData);
        }

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
                'name' => $member['first_name'] . " " .  $member['last_name'],
                'mobile' => $member['phone_number']
            ]);
        }

        return $this->response->setJSON(['error' => 'Member not found'])->setStatusCode(404);
    }


    public function view($id)
    {
        helper('form');

        $model = new MembersModel();
        $member = $model->where('id', $id)->first();

        $userModel = model(UserModel::class);
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $data = [
            'member' => $member,
            'userInfo' => $userInfo,
            'title' => 'View - ' . $member['member_number']
        ];
        return view('members/view', $data);
    }

    public function edit($id)
    {
        helper('form');

        $memberModel = new MembersModel();
        $memberData = $memberModel->find($id);

        $beneficiaryModel = new BeneficiaryModel();
        $beneficiary = $beneficiaryModel->where('member_id', $id)->first();

        $userModel = model(UserModel::class);
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $data = [
            'title' => 'Edit Member - ' . $memberData['member_number'],
            'member' => $memberData,
            'userInfo' => $userInfo,
            'beneficiary' => $beneficiary
        ];

        return view('members/create', $data);
    }

    public function update()
    {
        log_message('debug', 'Update method called: ' . $this->request->getMethod());

        // Handle form submission
        if ($this->request->getMethod() !== 'POST') {
            return $this->response->setStatusCode(405)->setJSON([
                'success' => false,
                'message' => 'Invalid request method'
            ]);
        }

        // Get member ID
        $memberId = $this->request->getPost('member_id');
        if (!$memberId) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Member ID is required'
            ]);
        }

        $model = new MembersModel();

        // Check if member exists
        $existingMember = $model->find($memberId);
        if (!$existingMember) {
            return $this->response->setStatusCode(404)->setJSON([
                'success' => false,
                'message' => 'Member not found'
            ]);
        }

        // Handle file upload 
        $photoPath = $existingMember['photo_path']; // Default to existing photo
        $photo = $this->request->getFile('photo');

        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            // Upload new photo
            $newName = $photo->getRandomName();
            $photo->move(WRITEPATH . 'uploads', $newName);
            $photoPath = 'uploads/' . $newName;

            // Delete old photo if it exists
            if ($existingMember['photo_path'] && file_exists(WRITEPATH . $existingMember['photo_path'])) {
                unlink(WRITEPATH . $existingMember['photo_path']);
            }
        } elseif ($this->request->getPost('existing_photo')) {
            // Keep existing photo
            $photoPath = $this->request->getPost('existing_photo');
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

        // Prepare beneficiary data if provided
        $benFirstName = $this->request->getPost('beneficiaryFirstName');
        if ($benFirstName) {
            $beneficiaryData = [
                'first_name' => $this->request->getPost('beneficiaryFirstName'),
                'last_name' => $this->request->getPost('beneficiaryLastName'),
                'dob' => $this->request->getPost('beneficiaryDOB'),
                'phone_number' => $this->request->getPost('beneficiaryPhone'),
                'relationship' => $this->request->getPost('beneficiaryRelationship'),
                'is_beneficiary' => $this->request->getPost('isBeneficiary'),
                'entitlement_percentage' => $this->request->getPost('entitlementPercentage'),
                'member_id' => $memberId
            ];
        }

        // Validate and save
        if (!$model->validate($memberData)) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $model->errors()
            ]);
        }

        try {
            $model->db->transStart();

            // Update member data
            $model->update($memberId, $memberData);

            // Handle beneficiary data if provided
            if (isset($benFirstName)) {
                $beneficiaryModel = new BeneficiaryModel();

                // Check if this member already has a beneficiary
                $existingBeneficiary = $beneficiaryModel->where('member_id', $memberId)->first();

                if ($existingBeneficiary) {
                    // Update existing beneficiary
                    $beneficiaryModel->update($existingBeneficiary['id'], $beneficiaryData);
                } else {
                    // Insert new beneficiary
                    $beneficiaryModel->insert($beneficiaryData);
                }
            }

            $model->db->transComplete();

            if ($model->db->transStatus() === false) {
                throw new \Exception('Database transaction failed');
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Member updated successfully',
                'member_id' => $memberId
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Failed to update member: ' . $e->getMessage());

            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Failed to update member: ' . $e->getMessage()
            ]);
        }
    }
}
