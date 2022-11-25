<?php

namespace Database\Seeders;

use App\Models\House;
use Illuminate\Database\Seeder;

class HouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $grade = collect([
            $this->createGrade(
                'Blue',
            ),
            $this->createGrade(
                'Green',
            ),
            $this->createGrade(
                'Purple',
            ),
            $this->createGrade(
                'Red',
            )
        ]);
    }

    private function createGrade(string $title)
    {
        return House::factory()->create(compact('title'));
    }
}