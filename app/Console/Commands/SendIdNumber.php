<?php

namespace App\Console\Commands;

use App\Models\Mother;
use App\Mail\SendMidtermMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendIdNumber extends Command
{
    protected $signature = 'send:credentials';

    protected $description = 'Send Id number to parents';

    
    public function handle()
    {
        $mothers  = Mother::all();
       
        foreach ($mothers as $mother) {
            $idNumber = $mother->student->user->code();
            $name = $mother->student->last_name." ".$mother->student->first_name. " ".$mother->student->first_name;
            $message = "<p>Your child: $name login credentials are: Id Number: ".$idNumber." and password: password123 or password1234</p>";
            $subject = 'Portal Login Credentials';
            if($mother->email() !== ''){
                Mail::to($mother->email())->send(new SendMidtermMail($message, $subject));
            }
        }
    }
}
