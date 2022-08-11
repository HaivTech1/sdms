<?php

namespace App\Observers;

use App\Models\Property;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PropertyObserver
{
    /**
     * Handle the Property "created" event.
     *
     * @param  \App\Models\Property  $property
     * @return void
     */
    public function created(Property $property)
    {
        $property->slug = Str::slug($property->title. '_' . now()->timestamp);
        $property->save();
    }

    /**
     * Handle the Property "updated" event.
     *
     * @param  \App\Models\Property  $property
     * @return void
     */
    public function updated(Property $property)
    {
        //
    }

    /**
     * Handle the Property "deleted" event.
     *
     * @param  \App\Models\Property  $property
     * @return void
     */
    public function deleted(Property $property)
    {
        //
    }

    /**
     * Handle the Property "restored" event.
     *
     * @param  \App\Models\Property  $property
     * @return void
     */
    public function restored(Property $property)
    {
        //
    }

    /**
     * Handle the Property "force deleted" event.
     *
     * @param  \App\Models\Property  $property
     * @return void
     */
    public function forceDeleted(Property $property)
    {
        //
    }
}