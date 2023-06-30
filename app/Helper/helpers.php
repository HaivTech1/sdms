<?php

use App\NullAbout;
use App\Models\Fee;
use App\NullBanner;
use App\Models\Term;
use App\Models\User;
use App\Models\About;
use App\Models\Banner;
use App\Models\Period;
use App\Models\MidTerm;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\Student;
use App\Models\Subject;
use App\NullApplication;
use App\Models\Affective;
use App\Models\Cognitive;
use App\Models\Application;
use App\Models\Cummulative;
use App\Models\Psychomotor;
use App\Models\PrimaryResult;
use App\Scopes\HasActiveScope;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

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
    return round($denominator == 0 ? 0 : ($numerator / $denominator), 1);
}

function calculatePercentage($value, $total, $percentage)
{
    if ($total == 0) {
        return 0;
    }

    return ($value / $total) * $percentage;
}

function calculateStudentPosition($studentId, $model, $session, $term, $grade)
{
    $results = $model::where([
        'period_id' => $session,
        'term_id' => $term,
        'grade_id' => $grade
    ])->get();

    $studentTotalScores = [];

    foreach ($results as $result) {
        $totalScore = $result->getTotalScore();
        $studentTotalScores[$result->student_id] = $totalScore;
    }

    arsort($studentTotalScores);
    $studentPosition = array_search($studentId, array_keys($studentTotalScores)) + 1;
    $suffix = 'th';
    if ($studentPosition % 10 === 1 && $studentPosition % 100 !== 11) {
        $suffix = 'st';
    } elseif ($studentPosition % 10 === 2 && $studentPosition % 100 !== 12) {
        $suffix = 'nd';
    } elseif ($studentPosition % 10 === 3 && $studentPosition % 100 !== 13) {
        $suffix = 'rd';
    }

    $positionWithSuffix = $studentPosition . $suffix;
    return $positionWithSuffix;
}

function calculateStudentSubjectPosition($studentId, $model, $session, $term, $grade, $subjectId)
{
    $results = $model::where([
        'period_id' => $session,
        'term_id' => $term,
        'grade_id' => $grade,
        'subject_id' => $subjectId
    ])->get();

    $studentTotalScores = [];

    foreach ($results as $result) {
        $totalScore = $result->getTotalScore();
        $studentTotalScores[$result->student_id] = $totalScore;
    }

    arsort($studentTotalScores);
    $studentPosition = array_search($studentId, array_keys($studentTotalScores)) + 1;

    $suffix = 'th';
    if ($studentPosition % 10 === 1 && $studentPosition % 100 !== 11) {
        $suffix = 'st';
    } elseif ($studentPosition % 10 === 2 && $studentPosition % 100 !== 12) {
        $suffix = 'nd';
    } elseif ($studentPosition % 10 === 3 && $studentPosition % 100 !== 13) {
        $suffix = 'rd';
    }

    $positionWithSuffix = $studentPosition . $suffix;
    return $positionWithSuffix;
}


function examRemark($remark)
{
    $data = get_settings('exam_remark');

    if ($data) {
        foreach ($data as $key => $value) {
            $from = (float)$value['from'];
            $text = $value['text'];

            if ($remark >= $key && $remark <= $from) {
                return $text;
            }
        }
    }

    return 'FAILED';
}

function examGrade($grade)
{
    $data = get_settings('exam_grade');

    foreach ($data as $key => $value) {
        $from = (float)$value['from'];
        $text = $value['text'];

        if ($grade >= $key && $grade <= $from) {
            return $text;
        }
    }

    return 'F';
}

function exam10Color($grade)
{
    $data = get_settings('over_ten');

    foreach ($data as $key => $value) {
        $from = (float)$value['from'];
        $color = $value['color'];

        if ($grade >= $key && $grade <= $from) {
            return $color;
        }
    }

    return '#ff0000';
}

function exam20Color($grade)
{
    $data = get_settings('over_twenty');

    foreach ($data as $key => $value) {
        $from = (float)$value['from'];
        $color = $value['color'];

        if ($grade >= $key && $grade <= $from) {
            return $color;
        }
    }

    return '#ff0000';
}

function exam40Color($grade)
{
    $data = get_settings('over_fourty');

    foreach ($data as $key => $value) {
        $from = (float)$value['from'];
        $color = $value['color'];

        if ($grade >= $key && $grade <= $from) {
            return $color;
        }
    }

    return '#ff0000';
}

function exam60Color($grade)
{
    $data = get_settings('over_sixty');

    foreach ($data as $key => $value) {
        $from = (float)$value['from'];
        $color = $value['color'];

        if ($grade >= $key && $grade <= $from) {
            return $color;
        }
    }

    return '#ff0000';
}

function exam100Color($grade)
{
    $data = get_settings('over_hundred');

    foreach ($data as $key => $value) {
        $from = (float)$value['from'];
        $color = $value['color'];

        if ($grade >= $key && $grade <= $from) {
            return $color;
        }
    }

    return '#ff0000';
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

function cognitives($student, $term, $period)
{
    $cognitive = Cognitive::where('student_uuid', $student->id())->where('term_id', $term)->where('period_id', $period)->exists();
    return $cognitive;
}

function sum($first, $second)
{
    return $first + $second;
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
        return "Congratulations! You did well in all subjects in this term's $type. I am so pleased with you. Please keep it up";
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
        $comment = $info . ' ' . $comment. ' I look forward to a more excellent result from you!';
    }

    return $comment;
}

function class_average($grade, $subject, $term, $period)
{
    $subject = Subject::where('title', $subject)->first();
    $students = Student::withoutGlobalScope(new HasActiveScope)->where('grade_id', $grade)->get();
    $midterm = get_settings('midterm_format');
    $exam = get_settings('exam_format');

    $results = PrimaryResult::where('grade_id', $grade)
                 ->where('term_id', $term)
                 ->where('period_id', $period)
                 ->where('subject_id', $subject->id())
                 ->groupBy('student_id')
                 ->get([
                    'student_id',
                    DB::raw('SUM(' . generateColumnSumExpression($midterm) . ' + ' . generateColumnSumExpression($exam) . ') as total_score')
                ]);

    $total_score = 0;
    foreach ($results as $result) {
        $total_score += $result->total_score;
    }
    
    $average = $total_score / count($students);

    return ceil($average);
}

function generateColumnSumExpression($format)
{
    $columns = array_keys($format);
    $expression = '';

    foreach ($columns as $column) {
        $expression .= $column . ' + ';
    }

    $expression = rtrim($expression, ' + ');

    return $expression;
}

function calculateResult($value)
{
    $midtermFormat = get_settings('midterm_format');
    $examFormat = get_settings('exam_format');
    
    $midtermTotal = 0;
    $examTotal = 0;

    if (is_array($midtermFormat)) {
        foreach ($midtermFormat as $midtermKey => $midtermValue) {
            if (isset($value->$midtermKey)) {
                $midtermTotal += $value->$midtermKey;
            }
        }
    }

    if (is_array($examFormat)) {
        foreach ($examFormat as $examKey => $examValue) {
            if (isset($value->$examKey)) {
                $examTotal += $value->$examKey;
            }
        }
    }

    return $midtermTotal + $examTotal;
}

function payslipList()
{
    $array = [
        '1' => ['key' => 'basic', 'value' => 'basic', 'title' => 'Basic'],
        '2' => ['key' => 'rent', 'value' => 'rent' , 'title' => 'Rent'],
        '3' => ['key' => 'transport', 'value' => 'transport' , 'title' => 'Transport'],
        '4' => ['key' => 'utility', 'value' => 'utility' , 'title' => 'Utility'],
        '5' => ['key' => 'meal', 'value' => 'meal' , 'title' => 'Meal'],
        '6' => ['key' => 'medical', 'value' => 'medical' , 'title' => 'Medical'],
        '7' => ['key' => 'dressing', 'value' => 'dressing' , 'title' => 'Dressing'],
        '8' => ['key' => 'allowance', 'value' => 'allowance' , 'title' => 'Allowance'],
    ];

    return $array;
}

function error_processor($validator)
{
    $err_keeper = [];
    foreach ($validator->errors()->getMessages() as $index => $error) {
        array_push($err_keeper, ['code' => $index, 'message' => $error[0]]);
    }
    return $err_keeper;
}

function get_application_settings($name)
{
    $config = null;

    $paymentmethod = Setting::where('key', $name)->first();

    if ($paymentmethod) {
        $config = json_decode($paymentmethod->value, true);
    }

    return $config;
}

function env_update($key, $value)
{
    $path = base_path('.env');
    if (file_exists($path)) {
        file_put_contents($path, str_replace(
            $key . '=' . env($key),
            $key . '=' . $value,
            file_get_contents($path)
        ));
    }
}

function env_key_replace($key_from, $key_to, $value)
{
    $path = base_path('.env');
    if (file_exists($path)) {
        file_put_contents($path, str_replace(
            $key_from . '=' . env($key_from),
            $key_to . '=' . $value,
            file_get_contents($path)
        ));
    }
}

function remove_dir($dir)
{
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir . "/" . $object) == "dir") Helpers::remove_dir($dir . "/" . $object);
                else unlink($dir . "/" . $object);
            }
        }
        reset($objects);
        rmdir($dir);
    }
}

function get_settings($name)
{
    $config = null;
    $data = Setting::where(['key' => $name])->first();
    if (isset($data)) {
        $config = json_decode($data['value'], true);
        if (is_null($config)) {
            $config = $data['value'];
        }
    }
    return $config;
}

function setEnvironmentValue($envKey, $envValue)
{
    $envFile = app()->environmentFilePath();
    $str = file_get_contents($envFile);
    $oldValue = env($envKey);
    if (strpos($str, $envKey) !== false) {
        $str = str_replace("{$envKey}={$oldValue}", "{$envKey}={$envValue}", $str);
    } else {
        $str .= "{$envKey}={$envValue}\n";
    }
    $fp = fopen($envFile, 'w');
    fwrite($fp, $str);
    fclose($fp);
    return $envValue;
}

function insert_business_settings_key($key, $value = null)
{
    $data =  Setting::where('key', $key)->first();
    if (!$data) {
        DB::table('business_settings')->updateOrInsert(['key' => $key], [
            'value' => $value,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    return true;
}

function remove_invalid_charcaters($str)
{
    return str_ireplace(['\'', '"', ',', ';', '<', '>', '?'], ' ', $str);
}

function default_lang()
{
    return 'en';
}

if (! function_exists('translate')) {
    function translate($key, $replace = [])
    {
        if(strpos($key, 'validation.') === 0 || strpos($key, 'passwords.') === 0 || strpos($key, 'pagination.') === 0 || strpos($key, 'order_texts.') === 0) {
            return trans($key, $replace);
        }
        
        $key = strpos($key, 'messages.') === 0?substr($key,9):$key;
        $local = default_lang();
        App::setLocale($local);
        try {
            $lang_array = include(base_path('resources/lang/' . $local . '/messages.php'));
            $processed_key = ucfirst(str_replace('_', ' ', remove_invalid_charcaters($key)));

            if (!array_key_exists($key, $lang_array)) {
                $lang_array[$key] = $processed_key;
                $str = "<?php return " . var_export($lang_array, true) . ";";
                file_put_contents(base_path('resources/lang/' . $local . '/messages.php'), $str);
                $result = $processed_key;
            } else {
                $result = trans('messages.' . $key, $replace);
            }
        } catch (\Exception $exception) {
            info($exception);
            $result = trans('messages.' . $key, $replace);
        }

        return $result;
    }
}

function payment_percent($percent, $amount)
{
    $result = $percent * $amount; // 1.5% of 1000
    return $result;
}

function mode()
{
    $result = get_settings('maintenance_mode');

    if($result === 1){
        return true;
    }else{
        return false;
    }
}

if (!function_exists('hasPaidFullFee')) {
    function hasPaidFullFee($user, $gradeId) {
        $getFee = Fee::where([
            'grade_id' => $gradeId,
            'type' => $user->student->type,
            'term_id' => term('id'),
        ])->first();

        $sum = $getFee->details->sum('price');

        $totalPaid = DB::table('payments')->where([
            'student_uuid' => $user->student->id(),
            'term_id' => term('id'),
            'period_id' => period('id')
        ])->sum('amount');

        return [
            'status' => $totalPaid >= $sum,
            'owing' => $sum
        ];
    }
}

function getFormat($string) {
    $values = explode(',', $string);
    return $values;
}

function colorArray()
{
    $data = [
        'black' => '#000000',
        'red' => '#ff0000',
        'blue' => '#0000ff',
        'green' => '#00FF00',
    ];
    
    return $data;
}

if (!function_exists('generate_mapping')) {
    function generate_mapping($remarkArray, $gradeArray)
    {
        $mapping = [];

        foreach ($remarkArray as $key => $remark) {
            if (array_key_exists($key, $gradeArray)) {
                $range = "{$key}-{$gradeArray[$key]['from']}";
                $mapping[$gradeArray[$key]['text']] = "{$range}:{$remark['text']}";
            }
        }
        end($remarkArray);
        $lastKey = key($remarkArray);
        $lastRemark = $remarkArray[$lastKey];
        $numb = $lastKey - 1;
        $range = "0-{$numb}";
        $mapping['Fail'] = "{$range}:F";
        return $mapping;
    }
}
