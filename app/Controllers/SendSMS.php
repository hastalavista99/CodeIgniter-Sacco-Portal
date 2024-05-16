<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class SendSMS extends BaseController
{
    public function sendSMS($mobile, $msg)
    {
        $senderid = "PulaSacco";
        $apikey = '3dc432b323eb01abe90fac7a86f7445f';
        $partnerid = 6835;

        if (!empty($msg) && !empty($mobile)) {
            $msg = urlencode($msg);
            $finalURL = "https://send.macrologicsys.com/api/services/sendsms/?apikey=$apikey&partnerID=$partnerid&message=$msg&shortcode=$senderid&mobile=$mobile";

            // Initialize cURL session
            $ch = curl_init();

            // Set cURL options
            curl_setopt($ch, CURLOPT_URL, $finalURL);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Execute the cURL request
            $response = curl_exec($ch);

            // Check for errors
            if ($response === FALSE) {
                // Log error and provide feedback
                log_message('error', 'SMS sending failed: ' . curl_error($ch));
                curl_close($ch);
                return redirect()->back()->with('fail', 'User saved but SMS failed to send.');
            }

            // Close cURL session
            curl_close($ch);

            // Check response (assuming a successful response would contain a specific string)
            if (strpos($response, 'success') !== false) {
                return redirect()->back()->with('success', 'User saved and SMS sent successfully.');
            } else {
                // Log error and provide feedback
                log_message('error', 'SMS sending failed: ' . $response);
                return redirect()->back()->with('fail', 'User saved but SMS failed to send. Response: ' . $response);
            }
        } else {
            return redirect()->back()->with('fail', 'Mobile number or message is empty.');
        }
    }
}
