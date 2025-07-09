<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getHeaderLine('Authorization');

        if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return Services::response()->setJSON([
                'success' => false,
                'message' => 'Access denied: Missing or malformed Authorization header'
            ])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }

        $token = $matches[1];

        try {
            $key = getenv('JWT_SECRET');
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            // Optional: set decoded token data to request for controller use
            $request->user = $decoded->data;
        } catch (\Exception $e) {
            return Services::response()->setJSON([
                'success' => false,
                'message' => 'Invalid or expired token'
            ])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action needed after request
    }
}
