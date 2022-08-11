<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Str;

class ProductObserver
{
    public function created(Product $product)
    {
        $product->slug = Str::slug($product->title() . '_'. now()->timestamp);
        $product->save();
    }
}