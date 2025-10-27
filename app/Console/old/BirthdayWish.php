<?php

namespace App\Console\Commands;

use App\Traits\NotifiableParentsTrait;
use Carbon\Carbon;
use App\Models\Student;
use Illuminate\Console\Command;
use App\Mail\Student\BirthdayMail;
use Illuminate\Support\Facades\Mail;

class BirthdayWish extends Command
{
   
    protected $signature = 'birthday:wish';
    protected $description = 'send birthday wishes to parents';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $students = Student::all();
        $current_date = now()->format('d-m-Y');

        foreach ($students as $student) {
            if ($student->dob->format('d-m-Y') === $current_date) {

                $name = $student->last_name." ".$student->first_name. " ".$student->first_name;
                $year = Carbon::parse($student->dob)->age;
                $message = "<p> $name, as you turn $year today, we felicitate with you; wish you a happy birthday and many happy returns of thy day; filled with lots of love and fun. Do have a lovely new year. Cheers to a new age!</p>";
                $subject = 'Happy Birthday to you';

                try {
                    NotifiableParentsTrait::notifyParents($student, $message, $subject);
                    info("birthday wish sent"); 
                } catch (\Throwable $th) {
                    info("Email birthday failed: " . $th->getMessage());
                }
            }
        }
    }
}
