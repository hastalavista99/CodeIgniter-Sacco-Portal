<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\BankModel;

class BankController extends ResourceController
{
    use ResponseTrait;

    public function receive()
    {

        // Basic Authentication (Postman "Authorization" tab)
        $validUsername = getenv('BANK_API_USER');
        $validPassword = getenv('BANK_API_PASS');

        $authUser = $this->request->getServer('PHP_AUTH_USER');
        $authPass = $this->request->getServer('PHP_AUTH_PW');

        if ($authUser !== $validUsername || $authPass !== $validPassword) {
            return $this->respond([
                'header' => [
                    'messageID' => '',
                    'statusCode' => '401',
                    'statusDescription' => 'Unauthorized: Invalid Basic Auth credentials.'
                ]
            ], 401);
        }

        $json = $this->request->getJSON(true); // true = assoc array

        // Validate JSON structure
        if (!$json || !isset($json['header'], $json['request'])) {
            return $this->respond([
                'header' => [
                    'messageID' => $json['header']['messageID'] ?? '',
                    'statusCode' => '400',
                    'statusDescription' => 'The parameters are not valid or they are missing.'
                ]
            ], 400);
        }

        $header = $json['header'];
        $request = $json['request'];

        // (Optional) Check authorization
        // if ($header['connectionID'] !== 'UOE' || $header['connectionPassword'] !== '8786%$') {
        //     return $this->respond([
        //         'header' => [
        //             'messageID' => $header['messageID'],
        //             'statusCode' => '401',
        //             'statusDescription' => 'The caller is not authorized for this request.'
        //         ]
        //     ], 401);
        // }

        // Check for duplicate transaction
        $bankModel = new BankModel();
        $exists = $bankModel->where('paymentDate', $request['PaymentDate'])->first();
        if ($exists) {
            return $this->respond([
                'header' => [
                    'messageID' => $header['messageID'],
                    'statusCode' => '402',
                    'statusDescription' => 'Duplicate transaction detected'
                ]
            ], 402);
        }

        // TRY insert
        try {
            $data = [
                'transactionReferenceCode'   => $request['TransactionReferenceCode'] ?? '',
                'transactionDate'            => $request['TransactionDate'] ?? '',
                'totalAmount'                => $request['TotalAmount'] ?? 0,
                'currency'                   => $request['Currency'] ?? '',
                'documentReferenceNumber'    => $request['DocumentReferenceNumber'] ?? '',
                'bankCode'                   => $request['BankCode'] ?? '',
                'branchCode'                 => $request['BranchCode'] ?? '',
                'paymentDate'                => $request['PaymentDate'] ?? '',
                'paymentReferenceCode'       => $request['PaymentReferenceCode'] ?? '',
                'paymentCode'                => $request['PaymentCode'] ?? '',
                'paymentMode'                => $request['PaymentMode'] ?? '',
                'paymentAmount'              => $request['PaymentAmount'] ?? 0,
                'additionalInfo'             => $request['AdditionalInfo'] ?? '',
                'accountNumber'              => $request['AccountNumber'] ?? '',
                'accountName'                => $request['AccountName'] ?? '',
                'institutionCode'            => $request['InstitutionCode'] ?? '',
                'institutionName'            => $request['InstitutionName'] ?? ''
            ];

            $bankModel->insert($data);

            // Return success response
            return $this->respond([
                'header' => [
                    'messageID' => $header['messageID'],
                    'statusCode' => '200',
                    'statusDescription' => 'Payment successfully received'
                ],
                'response' => [
                    'TransactionReferenceCode' => $request['TransactionReferenceCode'],
                    'TransactionDate'          => $request['TransactionDate'],
                    'TransactionAmount'        => $request['PaymentAmount'],
                    'AccountNumber'            => $request['AccountNumber'],
                    'AccountName'              => $request['AccountName'],
                    'InstitutionCode'          => $request['InstitutionCode'],
                    'InstitutionName'          => $request['InstitutionName']
                ]
            ], 200);
        } catch (\Exception $e) {
            // Severe problem response
            return $this->respond([
                'header' => [
                    'messageID' => $header['messageID'],
                    'statusCode' => '405',
                    'statusDescription' => 'A severe problem has occurred.'
                ]
            ], 405);
        }
    }


    public function validateMember()
    {
        $json = $this->request->getJSON(true);

        // Save incoming request to a log file
        $logFile = WRITEPATH . 'logs/bank_validation_' . date('Ymd') . '.log';
        file_put_contents($logFile, "[" . date('Y-m-d H:i:s') . "] " . json_encode($json, JSON_PRETTY_PRINT) . PHP_EOL, FILE_APPEND);

        // Validate required fields
        if (
            !isset($json['request']['TransactionReferenceCode']) ||
            !isset($json['request']['TransactionDate'])
        ) {
            return $this->response->setStatusCode(400)->setJSON([
                'header' => [
                    'messageID' => uniqid(),
                    'statusCode' => '400',
                    'statusDescription' => 'Missing required fields in request'
                ],
                'response' => []
            ]);
        }

        $referenceCode = trim($json['request']['TransactionReferenceCode']);
        $transactionDate = $json['request']['TransactionDate'];

        // Load your model (adjust if your model name is different)
        $memberModel = new \App\Models\MembersModel();

        // Check if member exists
        $member = $memberModel->where('member_number', $referenceCode)->first();

        if (!$member) {
            return $this->response->setStatusCode(404)->setJSON([
                'header' => [
                    'messageID' => uniqid(),
                    'statusCode' => '404',
                    'statusDescription' => 'Member not found'
                ],
                'response' => []
            ]);
        }

        // Successful validation
        return $this->response->setStatusCode(200)->setJSON([
            'header' => [
                'messageID' => uniqid(),
                'statusCode' => '200',
                'statusDescription' => 'Successfully validated member'
            ],
            'response' => [
                'TransactionReferenceCode' => $referenceCode,
                'TransactionDate' => $transactionDate,
                'TotalAmount' => 0.0,
                'Currency' => '',
                'AdditionalInfo' => $member['first_name'] . ' ' . $member['last_name'],
                'AccountNumber' => $member['member_number'],
                'AccountName' => $member['first_name'] . ' ' . $member['last_name'],
                'InstitutionCode' => '2100082',
                'InstitutionName' => 'Eldoret University'
            ]
        ]);
    }
    
}
