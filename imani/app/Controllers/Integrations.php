<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BankModel;
use CodeIgniter\HTTP\ResponseInterface;

class Integrations extends BaseController
{
    public function index()
    {
        //
    }

    public function account()
    {
        helper('filesystem');
        $request = $this->request->getJSON(true);
        $header = $request['header'];
        $code = $header['statusCode'];
        // File writing logic
        if ($code == "200") {
            // Prepare the full data for writing
            $fullData = [
                'header' => $header,
                'response' => $request['response']
            ];
    
            // Convert data to JSON for easy readability and parsing
            $jsonResponse = json_encode($fullData, JSON_PRETTY_PRINT);
            // Use CodeIgniter's file handling
            $filePath = WRITEPATH . 'CO-OPresponse.txt';

            try {
                // Write the JSON response to the file
                if (write_file($filePath, $jsonResponse)) {
                    log_message('info', 'Response successfully written to file');
                    // You might want to return a success response
                    return $this->response->setJSON([
                        'status' => 'success',
                        'message' => 'Response saved successfully'
                    ]);
                } else {
                    log_message('error', 'Failed to write response to file');
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Failed to save response'
                    ])->setStatusCode(500);
                }
            } catch (\Exception $e) {
                log_message('error', 'Error writing response: ' . $e->getMessage());
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'An error occurred while saving the response'
                ])->setStatusCode(500);
            }
        }

        // Handle non-200 status code scenario
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Invalid status code'
        ])->setStatusCode(400);

        // $response = $request['response'];
        // $transactionReferenceCode = $response['TransactionReferenceCode'];
        // $transactionDate = $response['TransactionDate'];
        // $totalAmount = $response['TotalAmount'];
        // $currency = $response['Currency'];
        // $additionalInfo = $response['AdditionalInfo'];
        // $accountNumber = $response['AccountNumber'];
        // $institutionCode = $response['InstitutionCode'];
        // $institutionName = $response['InstitutionName'];
    }

    public function advise()
    {
        helper('filesystem');
        // Get JSON request data
        $request = $this->request->getJSON(true);
    
        // Check header status code
        $header = $request['header'];
        $code = $header['statusCode'];
    
        // File writing logic
        if ($code == "200") {
            // Prepare the full data for writing
            $fullData = [
                'header' => $header,
                'response' => $request['response']
            ];
    
            // Convert data to JSON for easy readability and parsing
            $jsonResponse = json_encode($fullData, JSON_PRETTY_PRINT);
    
            // Generate unique filename with timestamp
            $filePath = WRITEPATH . 'transaction_' . time() . '_' . uniqid() . '.json';
    
            try {
                // Write the JSON response to the file
                if (write_file($filePath, $jsonResponse)) {
                    // Log successful file write
                    log_message('info', 'Transaction response successfully written to file: ' . $filePath);
                    
                    return $this->response->setJSON([
                        'status' => 'success',
                        'message' => 'Transaction response saved successfully',
                        'file' => $filePath
                    ]);
                } else {
                    // Log file write failure
                    log_message('error', 'Failed to write transaction response to file');
                    
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Failed to save transaction response'
                    ])->setStatusCode(500);
                }
            } catch (\Exception $e) {
                // Log any exceptions during file writing
                log_message('error', 'Error writing transaction response: ' . $e->getMessage());
                
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'An error occurred while saving the transaction response'
                ])->setStatusCode(500);
            }
        }
    
        // Handle non-200 status code scenario
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Invalid status code'
        ])->setStatusCode(400);

        $response = $request['response'];
        $this->dbInsert($response);
        
    }

    public function dbInsert($response) 
    {
        $transactionReferenceCode = $response['TransactionReferenceCode'];
        $transactionDate = $response['TransactionDate'];
        $totalAmount = $response['TotalAmount'];
        $currency = $response['Currency'];
        $documentReferenceNumber = $response['DocumentReferenceNumber'];
        $bankCode = $response['BankCode'];
        $branchCode = $response['BranchCode'];
        $paymentDate = $response['PaymentDate'];
        $paymentReferenceCode = $response['PaymentReferenceCode'];
        $paymentCode = $response['PaymentCode'];
        $paymentMode = $response['PaymentMode'];
        $paymentAmount = $response['PaymentAmount'];
        $additionalInfo = $response['AdditionalInfo'];
        $accountNumber = $response['AccountNumber'];
        $accountName = $response['AccountName'];
        $institutionCode = $response['InstitutionCode'];
        $institutionName = $response['InstitutionName'];

        $bankModel = new BankModel();

        $data = [
            'transactionReferenceCode' => $transactionReferenceCode,
            'transactionDate' => $transactionDate,
            'totalAmount' => $totalAmount,
            'currency' => $currency,
            'documentReferenceNumber' => $documentReferenceNumber,
            'bankCode' => $bankCode,
            'branchCode' => $branchCode,
            'paymentDate' => $paymentDate,
            'paymentReferenceCode' => $paymentReferenceCode,
            'paymentCode' => $paymentCode,
            'paymentMode' => $paymentMode,
            'paymentAmount' => $paymentAmount,
            'additionalInfo' => $additionalInfo,
            'accountNumber' => $accountNumber,
            'accountName' => $accountName,
            'institutionCode' => $institutionCode,
            'institutionName' => $institutionName
        ];

        $query = $bankModel->insert($data);
        if(!$query){
            log_message('error', 'Bank query not completed'. $query);
        }
    }
}
