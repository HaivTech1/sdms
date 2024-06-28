<?php

namespace App\Traits;

trait WhatsappMessageTrait
{

    public static function sendStaff(string $message, string $type)
    {
        try {
            sendWaMessage($message, $type);
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public static function sendParent($student, string $message, string $mediaFilePath = null)
    {
        try {

            if (get_settings('whatsapp_result_notification' === 1)) {
                if (get_settings('whatsapp_father_notification') === 1 && isset($student->father) && !empty($student->father->phone)) {
                    sendWaMessage($student->father->phone, $message, $mediaFilePath);
                }

                if (get_settings('whatsapp_mother_notification') === 1 && isset($student->mother) && !empty($student->mother->email)) {
                    sendWaMessage($student->mother->phone, $message, $mediaFilePath);
                }
            }
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }
}