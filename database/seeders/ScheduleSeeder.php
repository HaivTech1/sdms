<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Schedule;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schedule::factory()->create([
            'slug'      => 'Student',
            'time_in'   =>  '07:00',
            'time_out'  =>  '16:00',
        ]);

        Schedule::factory()->create([
            'slug'      => 'Teacher',
            'time_in'     =>  '06:30',
            'time_out'     =>  '16:30',
        ]);

        Schedule::factory()->create([
            'slug'      => 'Administator',
            'time_in'     =>  '06:30',
            'time_out'     =>  '16:30',
        ]);
    }
       
}
