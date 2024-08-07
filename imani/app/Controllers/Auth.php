<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Libraries\Hash;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

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

    // User login
    public function loginUser(){

        helper(['form', 'url']); // Load form and URL helpers

        if (! $this->request->is('post')) {
            return view('auth/login');
        }

        $rules = [
            'name' => 'required',
            'password' => 'required|min_length[5]|max_length[20]'
        ];

        if (! $this->validate($rules)) {
            return view('auth/login', [
                'validation' => $this->validator
            ]);
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
                    return redirect()->to('/dashboard');
                }
            } else {
                session()->setFlashdata('fail', 'User not found');
                return redirect()->to('auth/login')->withInput();
            }
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
    public function logout(){
        if(session()->has('loggedInUser'))
        {
            session()->remove('loggedInUser');

        }

        return redirect()->to('/auth?access=loggedout')->with('fail', "You are logged out");
    }
}
