<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run()
    {
        $category = collect([
            $this->createEvent(
                'Public holiday',
                date('Y-m-d'),
                date('Y-m-d'),
                'bg-primary',
                1,
                1,
                1
            ),
        ]);
        $category = collect([
            $this->createEvent(
                'Resumption',
                date('Y-m-d'),
                date('Y-m-d'),
                'bg-warning',
                1,
                1,
                1
            ),
        ]);
    }

    private function createEvent(string $title, string $start, string $end, string $category, int $period_id, int $term_id, int $author_id)
    {
        return Event::factory()->create(compact('title', 'start', 'end', 'category', 'period_id', 'term_id', 'author_id'));
    }
}
