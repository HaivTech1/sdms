<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productCategory = collect([
            $this->createProductCategory(
                'Outdoors',
                'outdoors',
            ),
            $this->createProductCategory(
                'Beauty',
                'beauty',
            ),
            $this->createProductCategory(
                'Environment',
                'environment',
            ),
            $this->createProductCategory(
                'Family',
                'family',
            ),
            $this->createProductCategory(
                'Decor',
                'decor',
            ),
            $this->createProductCategory(
                'Fitness',
                'fitness',
            ),
            $this->createProductCategory(
                'Health',
                'health',
            ),
            $this->createProductCategory(
                'Diy',
                'd-i-y',
            ),
            $this->createProductCategory(
                'Furniture',
                'furniture',
            ),
        ]);
    }

    private function createProductCategory(string $name, string $slug)
    {
        return ProductCategory::factory()->create(compact('name', 'slug'));
    }
}