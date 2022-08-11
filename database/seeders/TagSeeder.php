<?php

namespace Database\Seeders;

use App\Models\Post;
use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Thread;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = collect([
            $this->createTag(
                'Outdoors',
                'outdoors',
                'tags/outdoors.jpg'
            ),
            $this->createTag(
                'Health',
                'health',
                'tags/health.jpg'
            ),
            $this->createTag(
                'Environment',
                'Environment',
                'tags/environment.jpg'
            ),
            $this->createTag(
                'Fitness',
                'fitness',
                'tags/fitness.jpg'
            ),
            $this->createTag(
                'Family',
                'family',
                'tags/family.jpg'
            ),
            $this->createTag(
                'Decor',
                'decor',
                'tags/decor.jpg'
            ),
            $this->createTag(
                'Beauty',
                'beauty',
                'tags/beauty.jpg'
            ),
            $this->createTag(
                'DIY',
                'd-i-y',
                'tags/diy.jpg'
            ),
        ]);

        Post::all()->each(function ($post) use ($tags) {
            $post->syncTags(
                $tags->random(rand(0, $tags->count()))
                ->take(3)
                ->pluck('id')
                ->toArray(),
            );
        });
    }

    private function createTag(string $name, string $slug, string $image)
    {
        return Tag::factory()->create(compact('name', 'slug', 'image'));
    }
}