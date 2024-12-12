<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Libraries\Hash;
use App\Models\AgentModel;
use App\Models\MembersModel;
use App\Models\OTPModel;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use PHPUnit\Framework\Attributes\WithoutErrorHandler;

class Auth extends BaseController
{

    protected $helpers = ['form'];
    public function index()
    {
        helper('form');
        return view('auth/login');
    }

    public function register()
    {
        helper('form');
        return view('auth/register');
    }

    public function userDetails()
    {
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $data = [
            'title' => 'Dashboard',
            'userInfo' => $userInfo,
        ];

        return $data;
    }

    // Save new user to database
    public function registerUser()
    {
        helper('form');
        // validate user input
        if (! $this->request->is('post')) {
            return view('auth/register');
        }
        $validated = [
            'name' => 'required',
            'email' => 'required|valid_email',
            'password' => 'required|min_length[5]|max_length[20]',
            'passwordConf' => 'required|min_length[5]|max_length[20]|matches[password]'
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
            'name' => $name,
            'email' => $email,
            'password' => Hash::encrypt($password)
        ];


        // storing data
        $userModel = new \App\Models\UserModel();
        $query = $userModel->save($data);
        if (! $query) {
            return redirect()->back()->with('fail', 'Saving User failed');
        } else {
            return redirect()->back()->with('Success', 'Saved User');
        }
    }

    // User login
    public function loginUser()
    {

        helper(['form', 'url']); // Load form and URL helpers

        if (! $this->request->is('post')) {
            return view('auth/login');
        }

        $rules = [
            'name' => [
                'rules' => 'required',
                'label' => 'Username',
                'errors' => [
                    'required' => 'Please enter your username'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'label' => 'Password',
                'errors' => [
                    'required' => 'Please enter your password'
                ]
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()->to('/')->withInput()->with('errors', $this->validator->getErrors());
        } else {
            // User details in database
            $name = $this->request->getPost('name');
            $password = $this->request->getPost('password');

            $userModel = new UserModel();
            $user = $userModel->where('name', $name)->first();

            if ($user) {
                $checkPassword = Hash::check($password, $user['password']);
                if (! $checkPassword) {
                    session()->setFlashdata('fail', 'Incorrect password provided');
                    return redirect()->to('auth/login')->withInput();
                } else {
                    // Process user info
                    $userId = $user['id'];
                    session()->set('loggedInUser', $userId);
                    if ($user['temp'] == '1') {
                        return redirect()->to('set/user?user=' . $user['id']);
                    }
                    return redirect()->to('/dashboard');
                }
            } else {
                session()->setFlashdata('fail', 'User not found');
                return redirect()->to('auth/login')->withInput();
            }
        }
    }


    public function editUser()
    {

        helper(['form, url']);

        $id = $this->request->getGet('id');
        $userModel = model(UserModel::class);
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);
        $user = $userModel->find($id);
        $data = [
            'user'  => $user,
            'title' => 'Edit User',
            'userInfo' => $userInfo,
            'id' => $id
        ];
        return view('users/edit', $data);
    }


    public function updateUser()
    {
        helper(['form, url']);

        $id = $this->request->getGet('id');
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $mobile = $this->request->getPost('mobile');
        $member_no = $this->request->getPost('memberNumber');
        $role = $this->request->getPost('role');
        $data = [
            'name' => $name,
            'member_no' => $member_no,
            'mobile' => $mobile,
            'email' => $email,
            'role' => $role
        ];

        $model = model(UserModel::class);

        if ($model->update($id, $data)) {
            // Update successful
            if ($role == 'agent') {
                $model = new AgentModel();
                $agentModel = new \App\Models\AgentModel();
                $lastAgent = $agentModel->selectMax('agent_no')->first();
                $lastAgentNumber = $lastAgent ? intval($lastAgent['agent_no']) : 0;

                // Increment the agent number by 1 and format it to be 3 digits (e.g., '001')
                $newAgentNumber = str_pad($lastAgentNumber + 1, 3, '0', STR_PAD_LEFT);

                // Prepare data for saving
                $agentData = [
                    'agent_no' => $newAgentNumber,
                    'name' => $name,
                    'mobile' => $mobile,
                    'email' => $email,
                ];
                $query = $model->save($agentData);
            }

            return redirect()->to('/users')->with('success', 'User updated successfully.');
        } else {
            // Update failed
            return redirect()->back()->withInput()->with('fail', 'Failed to update user. Try again later');
        }
    }

    public function setUser()
    {
        helper(['form', 'url']);
        $id = $this->request->getGet('user');
        $data = [
            'title' => 'Account Setup',
            'user' => $id
        ];
        return view('auth/new_user', $data);
    }

    public function setSave()
    {
        helper(['form', 'url']);
        if (! $this->request->is('post')) {
            return view('auth/login');
        }

        $rules = [
            'name' => 'required',
            'username' => [
                'rules' => 'required|min_length[4]|max_length[10]',
                'label' => 'username',
                'errors' => [
                    'required' => 'Username must be provided',
                    'min_length' => 'Username must be at least 4 characters long',
                    'max_length' => 'Username must not exceed 10 characters'
                ],
            ],
            'password' => [
                'rules' => 'required|min_length[5]|max_length[20]',
                'label' => 'Password',
                'errors' => [
                    'required' => 'You must provide a password',
                    'min_length' => 'Password must be at least 5 characters long',
                    'max_length' => 'Password must not be longer than 20 characters',
                ],
            ],
            'passwordConf' => [
                'rules' => 'required|matches[password]',
                'label' => 'Confirm Password',
                'errors' => [
                    'required' => 'Please confirm your password',
                    'matches' => 'Password confirmation does not match password',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            $data["validation"] = $this->validator;
            return redirect()->to('set/user')->withInput()->with('errors', $this->validator->getErrors());
        }
        $id = $this->request->getGet('user');
        $name = $this->request->getPost('name');
        $member_no = $this->request->getPost('membership');
        $username = $this->request->getPost('username');
        $pass = $this->request->getPost('password');

        $authModel = new UserModel();

        //in case of username exists
        $user = $authModel->where('name', $username)->first();
        if ($user > 0) {
            return redirect()->to('set/user')->withInput()->with('fail', 'Username already exists, try a different one');
        }

        $insertData = [
            'user' => $name,
            'member_no' => $member_no,
            'name' => $username,
            'password' => Hash::encrypt($pass),
        ];


        $query = $authModel->update($id, $insertData);
        if (!$query) {
            return redirect()->to('set/user')->withInput()->with('fail', 'Something went wrong, try again later');
        }
        return redirect()->to('set/sucess');
    }

    public function setSuccess()
    {
        $data = [
            'title' => 'Account Setup'
        ];
        return view('auth/success', $data);
    }

    public function confirmUser()
    {
        helper(['form', 'url']);
        $data = [
            'title' => 'Enter Your username'
        ];

        return view('auth/user_enter', $data);
    }

    public function checkUser()
    {
        helper(['form', 'url']);

        $username = $this->request->getPost('name');

        $userModel = new UserModel();
        $otpModel = new OTPModel();

        $query = $userModel->where('name', $username)->first();
        if (!$query) {
            return redirect()->back()->to('confirm/user')->with('fail', 'User not found. Enter correct username.');
        } else {
            $name = $query['name'];
            $id = $query['id'];
            $phone = $query['mobile'];
            
            $alpha_numeric = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $otp = substr(str_shuffle($alpha_numeric), 0, 6);
            $expires = date("U") + 300;
            $data = [
                'username' => $name,
                'otp' => Hash::encrypt($otp),
                'expiry' => $expires
            ];
            $otpQuery = $otpModel->save($data);
            if ($otpQuery) {
                $sms = "Use " . $otp . " as your OTP for Password Reset. It will be active for the next 5 minutes";
                $smsSend = new SendSMS();
                $smsSend->sendSMS($phone, $sms);
            }
            session()->set('userId', $id);
            session()->setFlashdata('success', 'OTP sent to mobile number');
            return redirect()->to('confirm/otp')->withInput();
        }
    }

    public function resendOTP(){
        helper(['form', 'url']);

        $userId = session()->get('userId');
        $userModel = new UserModel();
        $otpModel = new OTPModel();


        $user = $userModel->find($userId);
        $username = $user['name'];
        $mobile = $user['mobile'];

        // remove earlier otp
        $checkUser = $otpModel->where('username', $username)->first();
        if ($checkUser){
            $remove = $otpModel->where('username', $username)->delete();
        }
        
        $alpha_numeric = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $otp = substr(str_shuffle($alpha_numeric), 0, 6);
        $expires = date("U") + 300;
        $data = [
            'username' => $username,
            'otp' => Hash::encrypt($otp),
            'expiry' => $expires
        ];

        $otpQuery = $otpModel->save($data);
            if ($otpQuery) {
                $sms = "Use " . $otp . " as your OTP for Password Reset. It will be active for the next 5 minutes";
                $smsSend = new SendSMS();
                $smsSend->sendSMS($mobile, $sms);
            }
            session()->setFlashdata('success', 'OTP resent to mobile number');
            return redirect()->to('confirm/otp')->withInput();

    }

    public function confirmOTP()
    {
        helper(['form', 'url']);
        

        return view('auth/enter_otp');
    }

    public function checkOTP()
    {
        helper(['form', 'url']);

        if (! $this->request->is('post')) {
            return redirect()->to('auth/login')->with('fail', 'Sign In To Continue');
        }
        $id = $this->request->getGet('user');
        $otp = $this->request->getPost('onetime');

        $authModel = new UserModel();
        $authQuery = $authModel->find($id);

        if (!$authQuery) {
            return redirect()->back()->with('fail', 'User not found.');
        }

        $username = $authQuery['name'];

        $model = new OTPModel();
        $current = date("U"); // Unix timestamp for current time

        // Query to find the OTP record with matching username, OTP, and within the expiry period
        $otpRecord = $model->where('username', $username)
            ->where('expiry >=', $current)
            ->first();

        if ($otpRecord && Hash::check($otp, $otpRecord['otp'])) {
            // OTP is valid and within its validity period
            $data = [
                'user' => $id
            ];
            $model->where('username', $username)->delete();
            return redirect()->to('password/forgot')->with('success', 'Renew Your Password');
        } else {
            // OTP is invalid or has expired
            return redirect()->back()->with('fail', 'Incorrect or expired OTP. Please try again or click Resend to get a new one.');
        }
    }

    public function changeAuth()
    {
        helper(['form', 'url']);
        return view('auth/password_reset');
    }

    public function resetPassword()
    {
        helper(['form', 'url']);
        if (! $this->request->is('post')) {
            return redirect()->to('auth/login')->with('fail', 'Sign In To Continue');
        }

        $rules = [
            'password' => [
                'rules' => 'required|min_length[5]|max_length[20]',
                'label' => 'Password',
                'errors' => [
                    'required' => 'You must provide a password',
                    'min_length' => 'Password must be at least 5 characters long',
                    'max_length' => 'Password must not be longer than 20 characters',
                ],
            ],
            'passwordConf' => [
                'rules' => 'required|matches[password]',
                'label' => 'Confirm Password',
                'errors' => [
                    'required' => 'Please confirm your password',
                    'matches' => 'Password confirmation does not match password. Try again',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            $data["validation"] = $this->validator;
            return redirect()->to('password/forgot')->withInput()->with('errors', $this->validator->getErrors());
        }
        $id = $this->request->getGet('user');
        $password = $this->request->getPost('password');
        $passwordConf = $this->request->getPost('passwordConf');

        $authModel = new UserModel();

        // Hash new password
        $data = [
            'password' => Hash::encrypt($password),
        ];

        // Update password
        if ($authModel->update($id, $data)) {
            return redirect()->to('set/success');
        } else {
            return redirect()->to('auth/login')->withInput()->with('fail', 'Failed to update password. Contact admin for details.');
        }

    }
    // public function uploadImage(){
    //     helper('form');
    //     try {
    //         $loggedInUserId = session()->get('loggedInUser');
    //     $config['upload_path'] = getcwd().'/images';
    //     $file = $this->request->getFile('userImage')->getName();

    //     //if directory not present, then create
    //     if (! is_dir($config['upload_path'])) {
    //         mkdir($config['upload_path'], 0777, true);
    //     }

    //     // Get image.
    //     $image = $this->request->getFile('userImage');

    //     if(! $image->hasMoved() && $loggedInUserId)
    //     {
    //         $image->move($config['upload_path'], $file);

    //         $data = [
    //             'avatar' => $file,
    //         ];

    //         $userModel = new UserModel();
    //         $userModel->update($loggedInUserId, $data);

    //         return redirect()->to('/dashboard')->with('notification', 'Image Uploaded Successfuly');
    //     }
    //     else
    //     {
    //         return redirect()->to('/dashboard')->with('notification', 'Image Uploaded Failed');
    //     }
    //     } catch (Exception $e) {
    //         echo $e->getMessage();
    //     }

    // }


    // logout user 
    public function logout()
    {
        if (session()->has('loggedInUser')) {
            session()->remove('loggedInUser');
        }

        return redirect()->to('/auth?access=loggedout')->with('fail', "You are logged out");
    }
}
