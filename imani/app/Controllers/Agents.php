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
            return redirect()->to('/agents')->with('fail', 'Saving Agent failed');
        } 
        else
        {
            
            return redirect()->to('/agents')->with('success', 'Sucessfully Created an Agent');
        }
    }

    public function editAgent()
    {
        helper('form');
        $id = $this->request->getGet('id');
        $model = model(AgentModel::class);
        $userModel = model(UserModel::class);
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);
        $agent = $model->find($id);
        $data = [
            'agent'  => $agent,
            'title' => 'Edit Agent',
            'userInfo' => $userInfo,
            'id' => $id
        ];
        return view('agents/edit', $data);
    }

    public function updateAgent()
    {
        helper(['form', 'url']);
        $id = $this->request->getGet('id');
        $name = $this->request->getPost('name');
        $mobile = $this->request->getPost('mobile');
        $email = $this->request->getPost('email');
        $data = [
            'name' => $name,
            'mobile' => $mobile,
            'email' => $email
        ];

        $model = model(AgentModel::class);

        if ($model->update($id, $data)) {
            // Update successful
            return redirect()->to('/agents')->with('success', 'Agent updated successfully.');
        } else {
            // Update failed
            return redirect()->back()->withInput()->with('fail', 'Failed to update agent.');
        }
        
    }
    public function deleteAgent()
    {
        helper(['form', 'url']);

        $id = $this->request->getGet('id');
        $model = model(AgentModel::class);
        $agent = $model->delete($id);
        if($agent)
        {
            return redirect()->to('/agents')->with('success', 'Agent deleted successfully.');
        }
        
    }


}
