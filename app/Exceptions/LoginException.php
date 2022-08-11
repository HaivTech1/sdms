<?php

namespace App\Exceptions;

use Exception;

class LoginException extends Exception
{
    function render()
    {
    return view('errors.login');
    }
}
