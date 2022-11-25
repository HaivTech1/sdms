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
            'slug'      => 'Students',
            'time_in'     =>  Carbon::now()->format('H:i:s'),
            'time_out'  =>  Carbon::now()->format('H:i:s'),
        ]);

        Schedule::factory()->create([
            'slug'      => 'Teachers',
            'time_in'     =>  Carbon::now()->format('H:i:s'),
            'time_out'  =>  Carbon::now()->format('H:i:s'),
        ]);

        Schedule::factory()->create([
            'slug'      => 'Administator',
            'time_in'     =>  Carbon::now()->format('H:i:s'),
            'time_out'  =>  Carbon::now()->format('H:i:s'),
        ]);
    }
       
}
