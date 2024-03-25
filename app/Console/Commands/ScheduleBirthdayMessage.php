<?php

namespace App\Console\Commands;

use App\Models\Student;
use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Traits\NumberBroadcast;
use Illuminate\Support\Facades\DB;

class ScheduleBirthdayMessage extends Command
{
    
    protected $signature = 'schedule:birthday';

    
    protected $description = 'This command will send a birthday message to the parents whatsapp number.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $students = Student::all();
        $current_date = now()->format('m-d');
        $currentDate = now()->format('d-m-Y');

        foreach ($students as $student) {
            $dateBeforeBirthday = Carbon::parse($student->dob)->subDay()->format('d-m-Y');
            $existingBirthday = DB::table('scheduled_birthdays')->insert([
                'student_id' => $student->id(),
                'date' => $dateBeforeBirthday,
            ]);

            if ($existingBirthday) {
                continue;
            }
            
            if ($dateBeforeBirthday === $currentDate) {
                $name = $student->last_name." ".$student->first_name. " ".$student->other_name;
                $year = Carbon::parse($student->dob)->age;
                $message = "{business.name} \\{business.address} \\{business.phone} \\ \\$name, as you turn $year today, we felicitate with you; wish you a happy birthday and many happy returns of thy day; filled with lots of love and fun. Do have a lovely new year. Cheers to a new age!";

                $numbers = [];
                if (!empty($student->mother->phone)) {
                    $numbers[] = $student->mother->phone;
                }

                if (!empty($student->father->phone)) {
                    $numbers[] = $student->father->phone;
                }
                
                try {
                    $data = [
                        'from' => $student->dob->format('m-d'),
                        'to' => '',
                        'time' =>'7:00',
                        'message' => $message,
                        'contacts' => $numbers,
                        'type' => 'number',
                        'method' => 'once',
                        'sender' => env('IMPRESSION_SENDER', '09066100815')
                    ];
                    $this->postRequest(env('IMPRESSION_URL')."/api/schedule/store", $data);
                } catch (\Throwable $th) {
                    info($th->getMessage());
                }

                info("Before Birthday: $dateBeforeBirthday and current date: $dateBeforeBirthday");
            }
        }
    }
}
