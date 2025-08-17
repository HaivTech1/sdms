<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('queue:work --stop-when-empty')->everyMinute();
        // $schedule->command('inspire')->hourly();
        $schedule->command('database:backup')->daily();
        // $schedule->command('send:credentials')->daily();
        $schedule->command('birthday:wish')->daily();
        $schedule->command('schedule:birthday')->everyFiveMinutes();
        $schedule->command('schedule:event')->everyFiveMinutes();
        $schedule->command('news:status')->everyTenMinutes();
        $schedule->command('grade:position')->everyFiveMinutes();
    }
    
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
