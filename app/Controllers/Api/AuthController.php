<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Controllers\SendSMS;
use App\Libraries\Hash;
use App\Models\MembersModel;
use App\Models\OTPModel;
use App\Models\RefreshTokenModel;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    use ResponseTrait;

    public function checkMember()
    {
        $json = $this->request->getJSON();

        // Validate presence of data
        if (!isset($json->memberNo) || !isset($json->mobile)) {
            return $this->respond([
                'success' => false,
                'message' => 'Member number and mobile are required'
            ], ResponseInterface::HTTP_BAD_REQUEST);
        }

        $memberNo = $json->memberNo;
        $mobile = $json->mobile;

        $model = new UserModel();
        $otpModel = new OTPModel();
        $member = $model->where([
            'member_no' => $memberNo,
            'mobile'    => $mobile
        ])->first();


        if (!$member) {
            return $this->respond([
                'success' => false,
                'message' => 'Invalid member number or mobile number'
            ], ResponseInterface::HTTP_UNAUTHORIZED);
        }

        $numeric = '0123456789';
        $otp = substr(str_shuffle($numeric), 0, 4);
        $expires = date("U") + 300;
        $data = [
            'username' => $mobile,
            'otp' => Hash::encrypt($otp),
            'expiry' => $expires
        ];

        $otpModel->where('username', $mobile)->delete();
        $otpQuery = $otpModel->save($data);
        if ($otpQuery) {
            try {
                $sms = "Use $otp as your OTP. Do not share this code.";
                $smsSend = new SendSMS();
                $smsSend->sendSMS($mobile, $sms);
            } catch (\Exception $e) {
                log_message('error', 'SMS failed: ' . $e->getMessage());
            }
        }

        return $this->respond([
            'success' => true,
            'message' => 'Validation successful',
            'otp' => $otp
        ]);
    }

    public function checkOtp()
    {
        $json = $this->request->getJSON();

        // Validate presence of data
        if (!isset($json->mobile) || !isset($json->code)) {
            return $this->respond([
                'success' => false,
                'message' => 'OTP and mobile are required'
            ], ResponseInterface::HTTP_BAD_REQUEST);
        }

        $otp = $json->code;
        $mobile = $json->mobile;

        $model = new UserModel();

        if (!$otp) {
            return $this->respond([
                'success' => false,
                'message' => 'Invalid code'
            ], ResponseInterface::HTTP_UNAUTHORIZED);
        }

        $model = new OTPModel();
        $current = date("U"); // Unix timestamp for current time

        // Query to find the OTP record with matching username, OTP, and within the expiry period
        $otpRecord = $model->where('username', $mobile)
            ->where('expiry >=', $current)
            ->first();

        if ($otpRecord && Hash::check($otp, $otpRecord['otp'])) {
            $model->where('username', $mobile)->delete();
            return $this->respond([
                'success' => true,
                'message' => 'OTP Validation successful'
            ]);
        } else {
            return $this->respond([
                'success' => false,
                'message' => 'Invalid or expired OTP'
            ], ResponseInterface::HTTP_UNAUTHORIZED);
        }
    }

    public function login()
    {
        $json = $this->request->getJSON();

        // Validate presence of data
        if (!isset($json->memberNo) || !isset($json->password)) {
            return $this->respond([
                'success' => false,
                'message' => 'Member number and password are required'
            ], ResponseInterface::HTTP_BAD_REQUEST);
        }

        $memberNo = $json->memberNo;
        $password = $json->password;

        $model = new UserModel();
        $member = $model->where('member_no', $memberNo)->first();

        if (!$member || !password_verify($password, $member['password'])) {
            return $this->respond([
                'success' => false,
                'message' => 'Invalid member number or password'
            ], ResponseInterface::HTTP_UNAUTHORIZED);
        }

        // Create JWT token
        $key = getenv('JWT_SECRET');
        $payload = [
            'iss' => 'pay.macrologicsys.com',
            'aud' => 'sacco',
            'iat' => time(),
            'exp' => time() + 3600, // 1 hour
            'data' => [
                'memberNo' => $member['member_no'],
                'name' => $member['name'],
                'email' => $member['email'],
                'phoneNumber' => $member['mobile']
            ]
        ];

        $jwt = JWT::encode($payload, $key, 'HS256');

        $refreshToken = bin2hex(random_bytes(64)); // secure random string
        $expiresAt = date('Y-m-d H:i:s', time() + 60 * 60 * 24 * 7); // 7 days

        $refreshModel = new RefreshTokenModel();
        $refreshModel->insert([
            'member_no' => $member['member_no'],
            'token' => $refreshToken,
            'expires_at' => $expiresAt,
        ]);

        return $this->respond([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'token' => $jwt,
                'refresh_token' => $refreshToken,
                'user' => [
                    'memberId' => $member['member_no'],
                    'name' => $member['name'],
                    'email' => $member['email'],
                    'phoneNumber' => $member['mobile']
                ]
            ]
        ]);
    }

    public function refresh()
    {
        $json = $this->request->getJSON();
        if (!isset($json->refresh_token)) {
            return $this->respond([
                'success' => false,
                'message' => 'Refresh token is required'
            ], ResponseInterface::HTTP_BAD_REQUEST);
        }

        $refreshToken = $json->refresh_token;

        $model = new RefreshTokenModel();
        $record = $model->where('token', $refreshToken)->first();

        if (!$record || strtotime($record['expires_at']) < time()) {
            return $this->respond([
                'success' => false,
                'message' => 'Refresh token is invalid or expired'
            ], ResponseInterface::HTTP_UNAUTHORIZED);
        }

        // Get the user
        $userModel = new UserModel();
        $member = $userModel->where('member_no', $record['member_no'])->first();

        $key = getenv('JWT_SECRET');
        $payload = [
            'iss' => 'pay.macrologicsys.com',
            'aud' => 'sacco',
            'iat' => time(),
            'exp' => time() + 3600,
            'data' => [
                'memberNo' => $member['member_no'],
                'name' => $member['name'],
                'email' => $member['email'],
                'phoneNumber' => $member['mobile']
            ]
        ];

        $newJwt = JWT::encode($payload, $key, 'HS256');

        return $this->respond([
            'success' => true,
            'token' => $newJwt
        ]);
    }
}
