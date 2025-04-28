<?php

if (!function_exists('user_can')) {
    function user_can($permission)
    {
        $session = session();

        // Assuming you store user info in session under 'user'
        $user = $session->get('userInfo');

        if (!$user || !isset($user['permissions'])) {
            return false;
        }

        $permissions = json_decode($user['permissions'], true);

        if (empty($permissions)) {
            return false;
        }

        return in_array($permission, $permissions);
    }
}
