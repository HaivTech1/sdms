<?php

use App\Models\User;
use App\NullApplication;
use App\Models\Application;

function application($key)
{
        $application = Application::first() ?? NullApplication::make();

        if ($application) {

            return $application->{$key};
        }
}