<?php

if (!function_exists('user_can')) {
    function user_can(string $permission): bool
    {
        $session = session();
        if (! $session->has('loggedInUser')) return false;

        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($session->get('loggedInUser'));
        $permissions = json_decode($user['permissions'] ?? '[]', true);

        return in_array($permission, $permissions);
    }
}

