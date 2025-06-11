<?php

use App\Models\SystemParameterModel;

if (!function_exists('get_system_parameter')) {
    function get_system_parameter($key, $default = null)
    {
        static $parameters = null;

        if ($parameters === null) {
            $model = new SystemParameterModel();
            $parameters = [];
            foreach ($model->findAll() as $param) {
                $parameters[$param['param_key']] = $param['param_value'];
            }
        }

        return $parameters[$key] ?? $default;
    }
}
