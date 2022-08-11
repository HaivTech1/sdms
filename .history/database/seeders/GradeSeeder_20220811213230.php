<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = collect([
            $this->createCategory(
                'Business',
            ),
        ]);
    }

    private function createCategory(string $title)
    {
        return PostCategory::factory()->create(compact('title'));
    }
}