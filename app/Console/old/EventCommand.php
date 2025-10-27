<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\Student;
use App\Traits\PostRequestTrait;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class EventCommand extends Command
{
    use PostRequestTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:event';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will schedule a message to send to parents for events of the weeks.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $students = Student::where('status', true)->get();
        $currentDate = now()->format('Y-m-d');
        $event = Event::where('start', '=', $currentDate)->first();

        info("Current date: $currentDate. It is the same day. Event date". $event->start->format('Y-m-d'). " Sending to ".count($students). " students");
        foreach ($students as $student) {

           
                $date = $event->start();
                $title = $event->title();
                $message = "{business.name} \\{business.address} \\ \\Dear Parent,  \\ We would love to let you know that $title will be coming up on $date. \\ \\ Kind Regards, \\ Management.";
                $name = $student->last_name." ".$student->first_name. " ".$student->other_name;

                $numbers = [];
                if (!empty($student->mother->phone)) {
                    $numbers[] = $student->mother->phone;
                }

                if (!empty($student->father->phone)) {
                    $numbers[] = $student->father->phone;
                }
                
                try {
                    $data = [
                        'from' => $event->start(),
                        'to' => '',
                        'time' =>'7:00:00',
                        'message' => $message,
                        'contacts' => $numbers,
                        'type' => 'number',
                        'method' => 'once',
                        'sender' => env('IMPRESSION_SENDER')
                    ];
                    $this->postRequest(env('IMPRESSION_URL')."/api/schedule/store", $data);
                    

                } catch (\Throwable $th) {
                    info($th->getMessage());
                }
                info("Scheduled event for $name");
        }
    }
}
