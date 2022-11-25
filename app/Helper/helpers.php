<?php

use App\Models\Term;
use App\Models\User;
use App\Models\Period;
use App\NullApplication;
use App\Models\Application;

function application($key)
{
        $application = Application::first() ?? NullApplication::make();

        if ($application) {

            return $application->{$key};
        }
}

if (! function_exists('divnum')) {

    function divnum($numerator, $denominator)
    {
        return $denominator == 0 ? 0 : ($numerator / $denominator);
    }

    function period($key)
    {
        $period = Period::where('status', true)->first();
        if ($period) {

            return $period->{$key};
        }
    }

    function term($key)
    {
        $term = Term::where('status', true)->first();
        if ($term) {

            return $term->{$key};
        }
    }
}