<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\MembersModel;
use App\Models\RefreshTokenModel;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    use ResponseTrait;

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
