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
        $institutionCode = getenv('BANK_API_INSTITUTION_CODE');
        $serviceName = getenv('BANK_API_SERVICE_NAME');



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

        if (
            !isset($header['serviceName'], $header['connectionID'], $header['connectionPassword']) ||
            !isset($request['InstitutionCode'])
        ) {
            return $this->respond([
                'header' => [
                    'messageID' => $header['messageID'] ?? '',
                    'statusCode' => '400',
                    'statusDescription' => 'Missing authentication parameters.'
                ]
            ], 400);
        }



        if (
            !hash_equals($validUsername, $header['connectionID']) ||
            !hash_equals($validPassword, $header['connectionPassword'])
        ) {
            return $this->respond([
                'header' => [
                    'messageID' => $header['messageID'],
                    'statusCode' => '401',
                    'statusDescription' => 'The caller is not authorized for this request.'
                ]
            ], 401);
        }

        // Institution code and service name validation
        if (
            !hash_equals($institutionCode, $request['InstitutionCode']) ||
            !hash_equals($serviceName, $header['serviceName'] ?? '')
        ) {
            return $this->respond([
                'header' => [
                    'messageID' => $header['messageID'] ?? '',
                    'statusCode' => '403',
                    'statusDescription' => 'Invalid Institution Code or Service Name.'
                ]
            ], 403);
        }

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

        // Try insert to db
        try {
            $data = [
                'transactionReferenceCode' => $request['TransactionReferenceCode'] ?? '',
                'transactionDate' => $request['TransactionDate'] ?? '',
                'totalAmount' => $request['TotalAmount'] ?? 0,
                'currency' => $request['Currency'] ?? '',
                'documentReferenceNumber' => $request['DocumentReferenceNumber'] ?? '',
                'bankCode' => $request['BankCode'] ?? '',
                'branchCode' => $request['BranchCode'] ?? '',
                'paymentDate' => $request['PaymentDate'] ?? '',
                'paymentReferenceCode' => $request['PaymentReferenceCode'] ?? '',
                'paymentCode' => $request['PaymentCode'] ?? '',
                'paymentMode' => $request['PaymentMode'] ?? '',
                'paymentAmount' => $request['PaymentAmount'] ?? 0,
                'additionalInfo' => $request['AdditionalInfo'] ?? '',
                'accountNumber' => $request['AccountNumber'] ?? '',
                'accountName' => $request['AccountName'] ?? '',
                'institutionCode' => $request['InstitutionCode'] ?? '',
                'institutionName' => $request['InstitutionName'] ?? ''
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
                    'TransactionDate' => $request['TransactionDate'],
                    'TransactionAmount' => $request['PaymentAmount'],
                    'AccountNumber' => $request['AccountNumber'],
                    'AccountName' => $request['AccountName'],
                    'InstitutionCode' => $request['InstitutionCode'],
                    'InstitutionName' => $request['InstitutionName']
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
        $validUsername = getenv('BANK_API_USER');
        $validPassword = getenv('BANK_API_PASS');
        $institutionCode = getenv('BANK_API_INSTITUTION_CODE');
        $serviceName = getenv('BANK_API_SERVICE_NAME');

        $json = $this->request->getJSON(true);

        // Basic structure check
        if (
            !isset($json['header']) ||
            !isset($json['request']) ||
            !is_array($json['header']) ||
            !is_array($json['request'])
        ) {
            return $this->failValidationError('Invalid request structure.');
        }

        $header = $json['header'];
        $request = $json['request'];

        // Validate header credentials
        if (
            !isset($header['connectionID'], $header['connectionPassword']) ||
            !hash_equals($validUsername, $header['connectionID']) ||
            !hash_equals($validPassword, $header['connectionPassword'])
        ) {
            return $this->respond([
                'header' => [
                    'messageID' => $header['messageID'] ?? uniqid(),
                    'statusCode' => '401',
                    'statusDescription' => 'The caller is not authorized for this request.'
                ]
            ], 401);
        }

        // Validate required request fields
        if (
            empty($request['TransactionReferenceCode']) ||
            empty($request['TransactionDate']) ||
            empty($request['InstitutionCode'])
        ) {
            return $this->respond([
                'header' => [
                    'messageID' => $header['messageID'] ?? uniqid(),
                    'statusCode' => '400',
                    'statusDescription' => 'Missing required fields in request.'
                ],
                'response' => []
            ], 400);
        }

        // Institution code and service name validation
        if (
            !hash_equals($institutionCode, $request['InstitutionCode']) ||
            !hash_equals($serviceName, $header['serviceName'] ?? '')
        ) {
            return $this->respond([
                'header' => [
                    'messageID' => $header['messageID'] ?? '',
                    'statusCode' => '403',
                    'statusDescription' => 'Invalid Institution Code or Service Name.'
                ]
            ], 403);
        }

        $referenceCode = trim($request['TransactionReferenceCode']);
        $transactionDate = $request['TransactionDate'];

        // Check member existence
        $memberModel = new \App\Models\MembersModel();
        $member = $memberModel->where('member_number', $referenceCode)->first();

        if (!$member) {
            return $this->respond([
                'header' => [
                    'messageID' => $header['messageID'] ?? uniqid(),
                    'statusCode' => '404',
                    'statusDescription' => 'Member not found.'
                ],
                'response' => []
            ], 404);
        }

        // Successful validation
        return $this->respond([
            'header' => [
                'messageID' => $header['messageID'] ?? uniqid(),
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
                'InstitutionCode' => $request['InstitutionCode'],
                'InstitutionName' => 'GlohaSacco'
            ]
        ]);
    }

}
// insert after bank insert
// transactions to be handled when processing the actual payment
// $db = \Config\Database::connect();
// $db->transStart(); // Start transaction

// // Insert journal entry
// $journalEntryData = [
//     'date'        => date('Y-m-d'), // or $request['TransactionDate']
//     'description' => 'Bank payment from ' . ($request['AccountName'] ?? 'Unknown'),
//     'reference'   => $request['TransactionReferenceCode'],
//     'created_by'  => 1, // replace with current user ID or system user
// ];

// $db->table('journal_entries')->insert($journalEntryData);
// $journalEntryId = $db->insertID();

// // Insert journal entry details
// $bankAccountId = 1; // your actual bank account ID
// $receivableAccountId = 2; // your actual income/receivable account ID
// $amount = $request['PaymentAmount'];

// $details = [
//     [
//         'journal_entry_id' => $journalEntryId,
//         'account_id'       => $receivableAccountId,
//         'debit'            => $amount,
//         'credit'           => 0.00
//     ],
//     [
//         'journal_entry_id' => $journalEntryId,
//         'account_id'       => $bankAccountId,
//         'debit'            => 0.00,
//         'credit'           => $amount
//     ]
// ];

// $db->table('journal_entry_details')->insertBatch($details);
// $memberNumber = $request['TransactionReferenceCode'];

// // Insert transactions log (optional but useful)
// $transaction = [
//     'member_number'       => $memberNumber, // or actual member if traceable
//     'service_transaction' => 'savings',
//     'transaction_type'    => 'Bank Payment',
//     'amount'              => $amount,
//     'payment_method'      => $request['PaymentMode'],
//     'transaction_date'    => date('Y-m-d'), // or $request['TransactionDate']
//     'description'         => 'Received from ' . ($request['AccountName'] ?? 'Unknown')
// ];

// $db->table('transactions')->insert($transaction);

// // Commit transaction
// $db->transComplete();

// if (!$db->transStatus()) {
//     return $this->respond([
//         'header' => [
//             'messageID' => $header['messageID'],
//             'statusCode' => '406',
//             'statusDescription' => 'Journal entry failed'
//         ]
//     ], 406);
// }