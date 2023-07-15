<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $productCategory = collect([
            $this->createProductCategory(
                'Utensils',
            ),
            $this->createProductCategory(
                'Cosmetics',
            ),
            $this->createProductCategory(
                'Gadgets',
            ), 
            $this->createProductCategory(
                'Electronics',
            ),
            $this->createProductCategory( 
                'Clothings',
            ),
            $this->createProductCategory(
                'Bags',
            ),
            $this->createProductCategory(
                'Shoes',
            ),
            $this->createProductCategory(
                'Furniture',
            ),
        ]);
    }

    private function createProductCategory(string $title)
    {
        return Category::factory()->create(compact('title'));
    }
}
