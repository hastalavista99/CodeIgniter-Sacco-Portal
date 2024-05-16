<?php

namespace App\Controllers;

use App\Models\MembersModel;
use App\Models\UserModel;
use App\Libraries\Hash;
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

            $senderid = "PulaSacco";
            $apikey = '3dc432b323eb01abe90fac7a86f7445f';
            $partnerid = 6835;

            if (!empty($msg) && !empty($mobile)) {
                $msg = urlencode($msg);
                $finalURL = "https://send.macrologicsys.com/api/services/sendsms/?apikey=$apikey&partnerID=$partnerid&message=$msg&shortcode=$senderid&mobile=$mobile";

                // Initialize cURL session
                $ch = curl_init();

                // Set cURL options
                curl_setopt($ch, CURLOPT_URL, $finalURL);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                // Execute the cURL request
                $response = curl_exec($ch);
                var_dump($response);

                // Check for errors
                if ($response === FALSE) {
                    // Error handling: Unable to send SMS
                    return redirect()->back()->with('fail', 'User saved but SMS failed to send.'.$response);
                }

                curl_close($ch);
            }
            return redirect()->back()->with('Success', 'Saved User');
        }
    }
}
