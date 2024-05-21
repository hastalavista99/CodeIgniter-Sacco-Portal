<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AgentModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\ResponseInterface;

class Agents extends BaseController
{
    public function index()
    {

        $userModel = new UserModel();
        $agents = new AgentModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $data = [
            'agents'  => $agents->findAll(),
            'title' => 'Agents',
            'userInfo' => $userInfo,
        ];
        return view('/agents/index', $data);
    }

    public function newAgent()
    {
        helper('form');
        // validate user input
        if (! $this->request->is('post')) {
            return view('/agents/index');
        }

        // save the user
        $name = $this->request->getPost('name');
        $agent_no = $this->request->getPost('agent_no');
        $mobile = $this->request->getPost('mobile');
        $email = $this->request->getPost('email');

        $data = [
            'agent_no'=> $agent_no,
            'name'=> $name,
            'mobile'=> $mobile,
            'email'=> $email,
        ];


        // storing data
        $agentInsert = new \App\Models\AgentModel();
        $query = $agentInsert->save($data);
        if (! $query) {
            return redirect()->back()->with('fail', 'Saving User failed');
        } 
        else
        {
            
            return redirect()->back()->with('Success', 'Saved User');
        }
    }


}
