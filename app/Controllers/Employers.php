<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EmployerModel;
use App\Models\UserModel;

class Employers extends BaseController
{
    protected $employerModel;

    public function __construct()
    {
        $this->employerModel = new EmployerModel();
    }

    /**
     * Show all employers
     */
    public function index()
    {
        $userModel = new UserModel();
        $loggedInUser = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUser);


        $data = [
            'employers' => $this->employerModel->findAll(),
            'userInfo' => $userInfo,
            'title' => 'Employers List'
        ];
        return view('employers/index', $data);
    }

    /**
     * Show create form
     */
    public function create()
    {
        $userModel = new UserModel();
        $loggedInUser = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUser);


        $data = [
            'userInfo' => $userInfo,
            'title' => 'Create Employer'
        ];
        return view('employers/create', $data);
    }

    /**
     * Save new employer
     */
    public function store()
    {
        $this->employerModel->save([
            'employer_name'      => $this->request->getPost('employer_name'),
            'contact_person'     => $this->request->getPost('contact_person'),
            'phone_number'       => $this->request->getPost('phone_number'),
            'email'              => $this->request->getPost('email'),
            'postal_address'     => $this->request->getPost('postal_address'),
            'physical_address'   => $this->request->getPost('physical_address'),
            'checkoff_code'      => $this->request->getPost('checkoff_code'),
            'deduction_frequency'=> $this->request->getPost('deduction_frequency'),
            'status'             => $this->request->getPost('status')
        ]);

        return redirect()->to('/employers')->with('success', 'Employer added successfully.');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $userModel = new UserModel();
        $loggedInUser = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUser);


        $data = [
            'userInfo' => $userInfo,
            'title' => 'Edit Employer',
            'employer' => $this->employerModel->find($id)
        ];
        return view('employers/edit', $data);
    }

    /**
     * Update employer
     */
    public function update($id)
    {
        $this->employerModel->update($id, [
            'employer_name'      => $this->request->getPost('employer_name'),
            'contact_person'     => $this->request->getPost('contact_person'),
            'phone_number'       => $this->request->getPost('phone_number'),
            'email'              => $this->request->getPost('email'),
            'postal_address'     => $this->request->getPost('postal_address'),
            'physical_address'   => $this->request->getPost('physical_address'),
            'checkoff_code'      => $this->request->getPost('checkoff_code'),
            'deduction_frequency'=> $this->request->getPost('deduction_frequency'),
            'status'             => $this->request->getPost('status')
        ]);

        return redirect()->to('/employers')->with('success', 'Employer updated successfully.');
    }

    /**
     * Delete employer
     */
    public function delete($id)
    {
        $this->employerModel->delete($id);
        return redirect()->to('/employers')->with('success', 'Employer deleted successfully.');
    }
}
