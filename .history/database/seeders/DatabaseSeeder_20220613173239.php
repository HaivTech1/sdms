<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\PostSeeder;
use Database\Seeders\ReviewSeeder;
use Database\Seeders\BookingSeeder;
use Database\Seeders\CommentSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\PropertySeeder;
use Database\Seeders\UserTableSeeder;
use Database\Seeders\ApplicationSeeder;
use Database\Seeders\PostCategorySeeder;
use Database\Seeders\ProductCategorySeeder;
use Database\Seeders\PropertyCategorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ApplicationSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(PropertyCategorySeeder::class);
        $this->call(PostCategorySeeder::class);
        $this->call(ProductCategorySeeder::class);
        $this->call(ProductSeeder::class);
        // $this->call(TagSeeder::class);
        $this->call(PostSeeder::class);
        $this->call(CommentSeeder::class);
        // $this->call(PropertySeeder::class);
        // $this->call(ReviewSeeder::class);
        // $this->call(BookingSeeder::class);
    }
}