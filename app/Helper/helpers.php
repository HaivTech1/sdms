<?php

use App\NullAbout;
use App\NullBanner;
use App\Models\Term;
use App\Models\User;
use App\Models\About;
use App\Models\Banner;
use App\Models\Period;
use App\Models\MidTerm;
use App\Models\Payment;
use App\NullApplication;
use App\Models\Affective;
use App\Models\Cognitive;
use App\Models\Application;
use App\Models\Cummulative;
use App\Models\Psychomotor;

function application($key)
{
        $application = Application::first() ?? NullApplication::make();

        if ($application) {

            return $application->{$key};
        }
}

function banner($key)
{
        $banner = Banner::first() ?? NullBanner::make();

        if ($banner) {

            return $banner->{$key};
        }
}

function about($key)
{
        $about = About::first() ?? NullAbout::make();

        if ($about) {

            return $about->{$key};
        }
}

function term($key)
{
    $term = Term::where('status', true)->first();
    if ($term) {
        return $term->{$key};
    }
}

function period($key)
{
    $period = Period::where('status', true)->first();
    if ($period) {

        return $period->{$key};
    }
}


function divnum($numerator, $denominator)
{
    return $denominator == 0 ? 0 : ($numerator / $denominator);
}

function remark($remark)
{
    if ($remark >= 80) {
        return 'EXCELLENT';
    }

    if ($remark >= 70) {
        return 'VERY GOOD';
    }

    if ($remark >= 60) {
        return 'GOOD';
    }

    if ($remark >= 55) {
        return 'PASS';
    }

    if ($remark >= 45) {
        return 'FAIR';
    }

    if ($remark >= 30) {
        return 'FAIL';
    }
}

function grade($grade)
{
    if ($grade >= 80) {
        return 'A';
    }

    if ($grade >= 70) {
        return 'B';
    }

    if ($grade >= 60) {
        return 'C';
    }

    if ($grade >= 55) {
        return 'D';
    }

    if ($grade >= 45) {
        return 'E';
    }

    if ($grade >= 30) {
        return 'F';
    }
}

function cummulatives($student, $term, $period, $grade)
{
    $cummulative = Cummulative::where('student_uuid', $student->id())->where('term_id', $term)->where('period_id', $period)->where('grade_id', $grade)->exists();
    return $cummulative;
}

function affectives($student, $term, $period)
{
    $affective = Affective::where('student_uuid', $student->id())->where('term_id', $term)->where('period_id', $period)->exists();
    return $affective;
}

function psychomotors($student, $term, $period)
{
    $psychomotor = Psychomotor::where('student_uuid', $student->id())->where('term_id', $term)->where('period_id', $period)->exists();
    return $psychomotor;
}

function sum($first, $second)
{
    return $first + $second;
}


function color($grade)
{
    if ($grade >= 80) {
        return '#000000';
    }

    if ($grade >= 70) {
        return '#000000';
    }

    if ($grade >= 60) {
        return '#ff00F1';
    }

    if ($grade >= 55) {
        return '#0000ff';
    }

    if ($grade >= 45) {
        return '#0000ff';
    }

    if ($grade >= 30) {
        return '#ff0000';
    }
}

function classAvg($grade)
{
    
}

function paymentCheck($tran, $ref)
{
    $payment = Payment::whereTrans_id($tran)->whereRef_id($ref)->first();

    return $payment;
}

function publishMidState($student, $period, $term)
{
    $results = MidTerm::where('student_id', $student)->where('period_id', $period)->where('term_id', $term)->get();

    if ($results->every(function ($item) {
        return $item->published;
    })) {
        return true;
    }else{
        return false;
    }
}
