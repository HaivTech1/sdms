<?php

namespace Database\Seeders;

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
                '2024/2025',
            ),
        ]);
    }

    private function createTerm(string $title)
    {
        return Term::factory()->create(compact('title'));
    }
}