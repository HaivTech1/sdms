<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GuardianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = Post::all();

        $posts->each(function ($post) use ($users) {
            Comment::factory()
                ->count(5)
                ->state(new Sequence(
                    fn () => [
                        'author_id'         => $users->random()->id,
                        'commentable_id'    => $post->id(),
                    ],
                ))
                ->create();
        });
    }
}