<?php

namespace App\Controllers;

use App\Models\OrganizationModel;
use App\Models\SystemParameterModel;
use App\Models\UserModel;

class AdminSettingsController extends BaseController
{
    public function getSettings()
    {
        $orgModel = new OrganizationModel();
        $paramModel = new SystemParameterModel();
        $userModel = new UserModel();

        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $data['profile'] = $orgModel->first();
        $data['parameters'] = $paramModel->findAll();
        $data['userInfo'] = $userInfo;
        $data['title'] = 'Admin Settings';

        return view('auth/system_settings', $data);
    }

    public function postSettings()
    {
        $orgModel = new OrganizationModel();
        $paramModel = new SystemParameterModel();

        $postData = $this->request->getPost();

        try {
            // Handle logo upload
            $file = $this->request->getFile('logo');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                if (!$file->move(WRITEPATH . 'uploads', $newName)) {
                    return redirect()->back()->withInput()->with('error', 'Logo upload failed.');
                }
                $postData['logo'] = $newName;
            }

            // Avoid saving system parameters into org table
            unset($postData['parameters']);

            $existing = $orgModel->first();

            if (!empty($existing)) {
                if (!$orgModel->update($existing['id'], $postData)) {
                    return redirect()->back()->withInput()->with('error', 'Failed to update organization profile.');
                }
            } else {
                if (!$orgModel->insert($postData)) {
                    return redirect()->back()->withInput()->with('error', 'Failed to create organization profile.');
                }
            }

            // Update system parameters
            $parameters = $this->request->getPost('parameters') ?? [];

            // Fetch all boolean parameters
            $allParams = $paramModel->findAll();
            foreach ($allParams as $param) {
                if ($param['param_value'] === 'true' || $param['param_value'] === 'false') {
                    // It's a boolean parameter
                    if (!array_key_exists($param['param_key'], $parameters)) {
                        // Checkbox was unchecked, set it as false
                        $parameters[$param['param_key']] = 'false';
                    }
                }
            }

            // Now update all parameters
            if (!empty($parameters)) {
                foreach ($parameters as $key => $value) {
                    $paramModel->where('param_key', $key)->set(['param_value' => $value])->update();
                }
            }

            return redirect()->back()->with('success', 'Settings saved successfully.');
        } catch (\Throwable $e) {
            log_message('error', 'Settings update error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'An unexpected error occurred. Please check logs.');
        }
    }


    // public function settings()
    // {
    //     $orgModel = new OrganizationModel();
    //     $paramModel = new SystemParameterModel();
    //     $userModel = new UserModel();

    //     $loggedInUserId = session()->get('loggedInUser');
    //     $userInfo = $userModel->find($loggedInUserId);

    //     $data['profile'] = $orgModel->first();
    //     $data['parameters'] = $paramModel->findAll();
    //     $data['userInfo'] = $userInfo;
    //     $data['title'] = 'Admin Settings';

    //     if ($this->request->getMethod() === 'post') {
    //         $postData = $this->request->getPost();

    //         try {
    //             // Handle logo upload
    //             $file = $this->request->getFile('logo');
    //             if ($file && $file->isValid() && !$file->hasMoved()) {
    //                 $newName = $file->getRandomName();
    //                 if (!$file->move(WRITEPATH . 'uploads', $newName)) {
    //                     return redirect()->back()->withInput()->with('error', 'Logo upload failed.');
    //                 }
    //                 $postData['logo'] = $newName;
    //             }

    //             // Avoid saving system parameters into org table
    //             unset($postData['parameters']);

    //             // Insert or update org profile
    //             if (!empty($data['profile'])) {
    //                 if (!$orgModel->update($data['profile']['id'], $postData)) {
    //                     return redirect()->back()->withInput()->with('error', 'Failed to update organization profile.');
    //                 }
    //             } else {
    //                 if (!$orgModel->insert($postData)) {
    //                     return redirect()->back()->withInput()->with('error', 'Failed to create organization profile.');
    //                 }
    //             }

    //             // Update system parameters
    //             $parameters = $this->request->getPost('parameters');
    //             if ($parameters && is_array($parameters)) {
    //                 foreach ($parameters as $key => $value) {
    //                     $paramModel->where('param_key', $key)->set(['param_value' => $value])->update();
    //                 }
    //             }

    //             return redirect()->back()->with('success', 'Settings saved successfully.');

    //         } catch (\Throwable $e) {
    //             log_message('error', 'Settings update error: ' . $e->getMessage());
    //             return redirect()->back()->withInput()->with('error', 'An unexpected error occurred. Please check logs.');
    //         }
    //     }


    //     return view('auth/system_settings', $data);
    // }
}
