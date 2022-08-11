<?php

namespace App\Exceptions;

use Exception;

class AdminException extends Exception
{
    function render()
    {
        return view('errors.403');
    }
}