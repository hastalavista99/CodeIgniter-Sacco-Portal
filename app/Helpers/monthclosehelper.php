<?php

use App\Models\SystemParameterModel;

if (!function_exists('is_closed_period')) {
    function is_closed_period($date)
    {
        $lastClosed = get_system_parameter('last_closed_period', null);
        if (!$lastClosed) return false;

        $inputPeriod = date('Y-m', strtotime($date));
        return $inputPeriod <= $lastClosed;
    }
}

if (!function_exists('get_system_date')) {
    /**
     * Returns the current working system date.
     *
     * @param string $format Format to return the date in, default 'Y-m-d'.
     * @return string Formatted system date.
     */
    function get_system_date($format = 'Y-m-d')
    {
        // Get the system date override from parameters
        $dateString = get_system_parameter('current_system_period', date('Y-m-d'));

        // Return formatted version
        return date($format, strtotime($dateString));
    }
}

