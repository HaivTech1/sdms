<?php

namespace Database\Seeders;

use App\Models\PostCategory;
use Illuminate\Database\Seeder;

class PostCategorySeeder extends Seeder
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
                'business',
                'post_categories/business.png'
            ),
            $this->createCategory(
                'Entertainment',
                'entertainment',
                'post_categories/entertainment.png'
            ),
            $this->createCategory(
                'Fashion tips',
                'fashiont_ips',
                'post_categories/fashion_tips.png'
            ),
            $this->createCategory(
                'Health and lifestyle',
                'health_and_lifestyle',
                'post_categories/health_and_lifestyle.png'
            ),
            $this->createCategory(
                'Literature(Stories and Poems)',
                'literature',
                'post_categories/literature.png'
            ),
            $this->createCategory(
                'Motivations and Quotes',
                'motivations_and_quotes',
                'post_categories/motivations_and_quotes.png'
            ),
            $this->createCategory(
                'Post-UTME Updates',
                'post-utme_updates',
                'post_categories/post-utme_updates.png'
            ),
        ]);
    }

    private function createCategory(string $name, string $slug, string $image)
    {
        return PostCategory::factory()->create(compact('name', 'slug', 'image'));
    }
}