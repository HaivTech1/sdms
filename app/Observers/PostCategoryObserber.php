<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\PostCategory;

class PostCategoryObserber
{
    public function created(PostCategory $category)
    {
        $category->slug = Str::slug($category->name. '_' . now()->timestamp);
        $category->save();
    }
}