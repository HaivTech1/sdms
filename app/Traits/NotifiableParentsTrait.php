<?php

namespace App\Traits;

use App\Mail\SendMidtermMail;
use Illuminate\Support\Facades\Mail;

trait NotifiableParentsTrait
{
    public static function notifyParents($student, $message, $subject)
    {
        if (get_settings('father_notification') === 1 && isset($student->father) && !empty($student->father->email)) {
            Mail::to($student->father->email())->send(new SendMidtermMail($message, $subject));
        }

        if (get_settings('mother_notification') === 1 && isset($student->mother) && !empty($student->mother->email)) {
            Mail::to($student->mother->email())->send(new SendMidtermMail($message, $subject));
        }

        if (get_settings('guardian_notification') === 1 && isset($student->guardian) && !empty($student->guardian->email)) {
            Mail::to($student->guardian->email())->send(new SendMidtermMail($message, $subject));
        }
    }
}
