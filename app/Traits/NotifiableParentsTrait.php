<?php

namespace App\Traits;

use App\Mail\SendMidtermMail;
use App\Jobs\SendExpoPushJob;
use App\Services\ExpoPushService;
use Illuminate\Support\Facades\Mail;

trait NotifiableParentsTrait
{
    public static function notifyParents($student, $body, $subject, $path = null)
    {
        $pushMessages = [];
        

        if (get_settings('father_notification') === 1 && isset($student->father)) {
            // keep existing email flow
            if (!empty($student->father->email)) {
                Mail::to($student->father->email())->send(new SendMidtermMail($body, $subject, $path));
            }            
        }

        if (get_settings('mother_notification') === 1 && isset($student->mother)) {
            if (!empty($student->mother->email)) {
                Mail::to($student->mother->email())->send(new SendMidtermMail($body, $subject, $path));
            }
        }

        if (get_settings('guardian_notification') === 1 && isset($student->guardian)) {
            if (!empty($student->guardian->email)) {
                Mail::to($student->guardian->email())->send(new SendMidtermMail($body, $subject, $path));
            }
        }

        if (isset($student->user) && !empty($student->user->device_token)) {
            $expo = app(ExpoPushService::class);
            $pushMessages[] = $expo->makeMessage($student->user->device_token, $subject, $body, ['student_uuid' => $student->uuid ?? null]);
        }

        if (!empty($pushMessages)) {
            // dispatch job to send in background
            SendExpoPushJob::dispatch($pushMessages);
        }
    }
}
