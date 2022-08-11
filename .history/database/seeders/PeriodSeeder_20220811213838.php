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
        $term = collect([
            $this->createTerm(
                '2022/2023',
            ),
            $this->createTerm(
                '2023/2024',
            ),
            $this->createTerm(
                '2024/2025',
            ),
            $this->createTerm(
                '2025/2026',
            ),
        ]);
    }

    private function createTerm(string $title)
    {
        return Period::factory()->create(compact('title'));
    }
}