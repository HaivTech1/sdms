<?php

namespace Database\Seeders;

use App\Models\Period;
use Illuminate\Database\Seeder;

class PeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $years = range('2020', date('Y'), 1);

        foreach ($years as $year) {
            Period::create(['title' => $year = $year . '/' . ($year + 1)]);
        }
    }

    
}