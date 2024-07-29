<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class SendSMS extends BaseController
{
    public function sendSMS($mobile, $msg)
    {
        $senderid = $_SERVER['SENDER_ID'];
        $apikey = $_SERVER['SMS_API_KEY'];
        $partnerid = $_SERVER['SMS_PARTNER_ID'];

        if (!empty($msg) && !empty($mobile)) {
            $msg = urlencode($msg);
            $finalURL = "https://send.macrologicsys.com/api/services/sendsms/?apikey=$apikey&partnerID=$partnerid&message=$msg&shortcode=$senderid&mobile=$mobile";

            // Initialize cURL session
            $ch = curl_init();

            // Set cURL options
            curl_setopt($ch, CURLOPT_URL, $finalURL);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // Bypass SSL verification (for development only)
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Bypass SSL verification (for development only)

            // Execute the cURL request
            $response = curl_exec($ch);

            // Check for errors
            if ($response === FALSE) {
                $curlError = curl_error($ch);
                log_message('error', 'SMS sending failed: ' . $curlError);
                curl_close($ch);
                return redirect()->back()->with('fail', 'Successful but SMS failed to send. Error: ' . $curlError);
            }

            // Close cURL session
            curl_close($ch);

            // Parse the response
            $responseData = json_decode($response, true);

            // Check if the response contains the expected data
            if (isset($responseData['responses'][0]['response-code']) && $responseData['responses'][0]['response-code'] == 200) {
                return redirect()->back()->with('success', 'Saved and SMS sent successfully.');
            } else {
                log_message('error', 'SMS sending failed: ' . $response);
                return redirect()->back()->with('fail', 'Saved but SMS failed to send. Response: ' . json_encode($responseData));
            }
        } else {
            return redirect()->back()->with('fail', 'Mobile number or message is empty.');
        }
    }
}
