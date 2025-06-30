<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MembersRegistrationModel;
use App\Models\MemberBeneficiariesModel;
use CodeIgniter\HTTP\ResponseInterface;

class Site extends BaseController
{

    public function siteRegister()
    {
        helper('form');

        $data = [
            'title' => 'Register Member',

        ]; 

        return view('site/register', $data);
    }

    
    public function memberNew()
    {
        if ($this->request->getMethod() !== 'POST') {
            return $this->response->setStatusCode(405)->setJSON([
                'success' => false,
                'message' => 'Method Not Allowed',
                'method' => $this->request->getMethod()
            ]);
        }


        $model = new MembersRegistrationModel();
        $beneficiaryModel = new MemberBeneficiariesModel();
        $data = $this->request->getPost();

        // Handle passport photo upload
        $passportPhoto = $this->request->getFile('passport_photo');
        if ($passportPhoto && $passportPhoto->isValid() && !$passportPhoto->hasMoved()) {
            $newName = uniqid('passport_') . '.' . $passportPhoto->getExtension();
            $uploadPath = FCPATH . 'uploads' . DIRECTORY_SEPARATOR;
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $passportPhoto->move($uploadPath, $newName);
            $data['passport_photo'] = $newName;
        } else {
            $data['passport_photo'] = null;
        }

        // Handle checkboxes and radio buttons
        $data['employer_authorization'] = $this->request->getPost('employerAuthorization') ? 1 : 0;
        $data['mobile_banking'] = $this->request->getPost('mobileBanking') ? 1 : 0;


        // Extract and decode beneficiaries (expects a JSON string from the form)
        $beneficiariesJson = $this->request->getPost('beneficiaries');
        $beneficiaries = [];
        if ($beneficiariesJson) {
            $decoded = json_decode($beneficiariesJson, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $beneficiaries = $decoded;
            } else if (!empty($beneficiariesJson)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'success' => false,
                    'message' => 'Invalid beneficiaries data.'
                ]);
            }
        }
        unset($data['beneficiaries']);

        // Insert registration
        if ($model->insert($data)) {
            $registrationId = $model->getInsertID();
            // Insert beneficiaries if any
            if (!empty($beneficiaries) && is_array($beneficiaries)) {
                foreach ($beneficiaries as $b) {
                    if (!empty($b['first_name']) && !empty($b['last_name'])) {
                        $b['registration_id'] = $registrationId;
                        $beneficiaryModel->insert($b);
                    }
                }
            }
            return $this->response->setStatusCode(200)->setJSON([
                'success' => true,
                'message' => 'Registration successful.'
            ]);
        } else {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Failed to save registration.'
            ]);
        }
    }
}
