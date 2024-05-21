<?php 

namespace App\Libraries;

use PHPUnit\Framework\Attributes\IgnoreFunctionForCodeCoverage;

class Hash 
{
    //encrypt user password 
    public static function encrypt($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public static function check($userPassword, $dbUserPassword)
    {
        if(password_verify($userPassword, $dbUserPassword))
        {
            return true;

        }

        return false;
    }
}