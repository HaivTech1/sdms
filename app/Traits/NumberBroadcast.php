<?php

namespace App\Traits;

trait NumberBroadcast
{
    public static function notify($student, $message)
    {
        if (get_settings('father_notification') === 1 && isset($student->father) && !empty($student->father->phone)) {
            sendWaMessage($student->father->phone, $message);
        }

        if (get_settings('mother_notification') === 1 && isset($student->mother) && !empty($student->mother->phone)) {
            sendWaMessage($student->mother->phone, $message);
        }

        if (get_settings('guardian_notification') === 1 && isset($student->guardian) && !empty($student->guardian->phone)) {
            sendWaMessage($student->guardian->phone, $message);
        }
    }
}
