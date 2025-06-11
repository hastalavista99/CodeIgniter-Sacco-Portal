<?php

namespace App\Controllers;

use App\Models\BalancesModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use App\Models\ExcelModel;
use App\Models\UserModel;

class Excel extends BaseController {

    public function uploadPage()
    {
        helper(['form', 'url']);

        $userModel = new UserModel();
        $userId = session()->get('loggedInUser');
        $userInfo = $userModel->find($userId);
        $balancesModel = new BalancesModel();
        $balances = $balancesModel->findAll();

        $data = [
            'title' => 'Balances Upload',
            'userInfo' => $userInfo,
            'balances' => $balances
        ];
        return view('users/balances', $data);
    }

    public function checkBalances()
    {
        helper(['form', 'url']);

        $userModel = new UserModel();
        $userId = session()->get('loggedInUser');
        $userInfo = $userModel->find($userId);
        $balancesModel = new BalancesModel();
        $balances = $balancesModel->where('member_no', $userInfo['member_no'])->first();

        $data = [
            'title' => 'Uploaded Balances',
            'userInfo' => $userInfo,
            'balances' => $balances
        ];
        return view('users/new_balances', $data);
    }

    public function upload() {
        $file = $this->request->getFile('file');
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $validTypes = [
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.ms-excel'
            ];
    
            if (in_array($file->getMimeType(), $validTypes)) {
                $filePath = $file->getTempName();
                $this->import_excel($filePath);
                return $this->response->setJSON(['success' => true, 'message' => 'Data imported successfully']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Invalid file type. Please upload an Excel file.']);
            }
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Please upload a valid Excel file.']);
        }
    }
    
    
    private function import_excel($filePath) {
        // Load your ExcelModel for database operations
        $excelModel = new ExcelModel();
        
        // Load PhpSpreadsheet classes
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    
        // Load the spreadsheet file from the provided path
        $spreadsheet = $reader->load($filePath);
    
        // Get data from the active sheet
        $data = $spreadsheet->getActiveSheet()->toArray();
    
        // Clear the table before importing new data (optional, depending on requirements)
        $excelModel->truncate();
    
        // Loop through the rows in the spreadsheet
        foreach ($data as $index => $row) {
            // Skip the header row if needed
            if ($index === 0) continue;
    
            // Prepare row data for insertion into the database
            $rowData = [
                'member_no' => $row[0] ?? null,  // Map columns to your table structure
                'shares'    => $row[1] ?? null,
                'deposits'  => $row[2] ?? null,
                'loan'      => $row[3] ?? null,
                // Add more columns as needed
            ];
    
            // Insert each row into the database
            $excelModel->insert($rowData);
        }
    }
    
}
