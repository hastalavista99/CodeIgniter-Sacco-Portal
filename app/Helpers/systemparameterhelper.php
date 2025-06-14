<?php

use App\Models\SystemParameterModel;


if (!function_exists('get_system_parameter')) {
    /**
     * Retrieves a system parameter by key, with optional default.
     *
     * @param string $key     The parameter key to look up.
     * @param mixed  $default The default value to return if the key is not found.
     * @return mixed
     */
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
