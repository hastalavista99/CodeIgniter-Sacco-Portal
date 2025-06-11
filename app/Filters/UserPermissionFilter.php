<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class UserPermissionFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Check if user is logged in
        if (! $session->has('loggedInUser')) {
            return redirect()->to('/login')->with('fail', 'You must be logged in');
        }

        // Check for required permissions passed in arguments
        if ($arguments) {
            $userModel = new \App\Models\UserModel();
            $user = $userModel->find($session->get('loggedInUser'));
            $permissions = json_decode($user['permissions'] ?? '[]', true);

            foreach ($arguments as $requiredPermission) {
                if (! in_array($requiredPermission, $permissions)) {
                    return redirect()->to('/unauthorized')->with('fail', 'Access denied');
                }
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No after logic needed
    }
}
