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
use App\Models\PrimaryResult;

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

function examRemark($remark)
{
    if ($remark >= 80.0 && $remark <= 100) {
        return 'EXCELLENT';
    }

    if ($remark >= 70.0 && $remark <= 79.9) {
        return 'VERY GOOD';
    }

    if ($remark >= 60.0 && $remark <= 69.9) {
        return 'GOOD';
    }

    if ($remark >= 58.0 && $remark <= 59.9) {
        return 'PASS';
    }

    if ($remark >= 56.0 && $remark <= 57.9) {
        return 'FAIR';
    }

    if ($remark < 56) {
        return 'FAILED';
    }
}

function examGrade($grade)
{
    if ($grade >= 80.0 && $grade <= 100) {
        return 'A';
    }

    if ($grade >= 70.0 && $grade <= 79.9) {
        return 'B';
    }

    if ($grade >= 60.0 && $grade <= 69.9) {
        return 'C';
    }

    if ($grade >= 58.0 && $grade <= 59.9) {
        return 'D';
    }

    if ($grade >= 56.0 && $grade <= 57.9) {
        return 'E';
    }

    if ($grade < 56) {
        return 'F';
    }
}

function exam10Color($grade)
{
    if ($grade >= 8.0 && $grade <= 10) {
        return '#000000';
    }

    if ($grade >= 7.0 && $grade <= 7.9) {
        return '#000000';
    }

    if ($grade >= 6.0 && $grade <= 6.9) {
        return '#00FF00';
    }

    if ($grade >= 5.8 && $grade <= 5.9) {
        return '#0000ff';
    }

    if ($grade >= 5.6 && $grade <= 5.79) {
        return '#0000ff';
    }

    if ($grade < 5.6) {
        return '#ff0000';
    }
}

function exam20Color($grade)
{
    if ($grade >= 16.0 && $grade <= 20) {
        return '#000000';
    }

    if ($grade >= 14.0 && $grade <= 15.9) {
        return '#000000';
    }

    if ($grade >= 12.0 && $grade <= 13.9) {
        return '#00FF00';
    }

    if ($grade >= 11.6 && $grade <= 11.9) {
        return '#0000ff';
    }

    if ($grade >= 11.2 && $grade <= 11.5) {
        return '#0000ff';
    }

    if ($grade < 11.2) {
        return '#ff0000';
    }
}

function exam40Color($grade)
{
    if ($grade >= 32.0 && $grade <= 40) {
        return '#000000';
    }

    if ($grade >= 28.0 && $grade <= 31.9) {
        return '#000000';
    }

    if ($grade >= 24.0 && $grade <= 27.9) {
        return '#00FF00';
    }

    if ($grade >= 23.2 && $grade <= 23.9) {
        return '#0000ff';
    }

    if ($grade >=22.4 && $grade <= 23.1) {
        return '#0000ff';
    }

    if ($grade < 22.4) {
        return '#ff0000';
    }
}

function exam60Color($grade)
{
    if ($grade >= 48.0 && $grade <= 60) {
        return '#000000';
    }

    if ($grade >= 42.0 && $grade <= 47.9) {
        return '#000000';
    }

    if ($grade >= 36.0 && $grade <= 41.9) {
        return '#00FF00';
    }

    if ($grade >= 34.8 && $grade <= 35.9) {
        return '#0000ff';
    }

    if ($grade >=33.6 && $grade <= 34.7) {
        return '#0000ff';
    }

    if ($grade < 33.6) {
        return '#ff0000';
    }
}

function exam100Color($grade)
{
    if ($grade >= 80.0 && $grade <= 100) {
        return '#000000';
    }

    if ($grade >= 70.0 && $grade <= 79.9) {
        return '#000000';
    }

    if ($grade >= 60.0 && $grade <= 69.9) {
        return '#00FF00';
    }

    if ($grade >= 58.0 && $grade <= 59.9) {
        return '#0000ff';
    }

    if ($grade >= 56.0 && $grade <= 57.9) {
        return '#0000ff';
    }

    if ($grade < 56) {
        return '#ff0000';
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

function publishExamState($student, $period, $term)
{
    $results = PrimaryResult::where('student_id', $student)->where('period_id', $period)->where('term_id', $term)->get();

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



