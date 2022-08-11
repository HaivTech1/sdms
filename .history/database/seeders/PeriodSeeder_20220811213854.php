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
        $period = collect([
            $this->createPeriod(
                '2022/2023',
            ),
            $this->createPeriod(
                '2023/2024',
            ),
            $this->createPeriod(
                '2024/2025',
            ),
            $this->createPeriod(
                '2025/2026',
            ),
        ]);
    }

    private function createPeriod(string $title)
    {
        return Period::factory()->create(compact('title'));
    }
}