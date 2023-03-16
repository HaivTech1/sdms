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
use App\Models\Subject;
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

// function flash($title=null, $message=null)
// {
//     $flash = app('App\Http\Flash');
//     if (func_num_args()==0) {
//         return $flash;
//     }
//     return $flash->info($title, $message);
// }

function generate_comment($scores, $info = '', $ratio = 0.4, $max = 100, $type = 'mid term')
{
    // Set the maximum score for each subject
    $max_score = $max;

    // Find the threshold for a weak subject (e.g. less than or equal to 40% of the maximum score)
    $threshold = round($max_score * $ratio);

    // Find the weak subject(s) (i.e. score less than or equal to the threshold)
    $weak_subjects = array_filter($scores, function ($score) use ($threshold) {
        return $score <= $threshold;
    });

    // If there are no weak subjects, return a "Congratulations" message
    if (empty($weak_subjects)) {
        return "Congratulations! You did well in all subjects in this term's $type. We are so pleased with you. Please keep it up";
    }

    // Generate comments only for the weak subject(s)
    $comments = [];
    foreach ($weak_subjects as $subject_id => $score) {
        $subject_name = Subject::find($subject_id)->title(); // assuming there is a title property on the Subject model
        $comment = "Your score in $subject_name is low. Your percentage score is " . round(($score/$max_score)*100) . "%.";

        $comments[] = $comment;
    }

    // Join the comments into a single string
    $comment = implode(' ', $comments);

     // If there are weak subjects, concatenate the info string to the beginning of the comment
     if (!empty($weak_subjects)) {
        $comment = $info . ' ' . $comment. ' We look forward to a more excellent result from you!';
    }

    return $comment;
}



