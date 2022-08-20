<?php

namespace App\Observers;

use App\Models\Fee;
use App\Models\Term;
use App\Models\Period;

class FeeObserver
{
    public function creating(Fee $fee)
    {
        $period = Period::where('status_id', true)->first();
        $term = Term::where('status_id', true)->first();

        $fee->period_id = $period->id();
        $fee->term_id = $term->id();
        $fee->save();
    }
    
    public function created(Fee $fee)
    {
        //
    }

    /**
     * Handle the Fee "updated" event.
     *
     * @param  \App\Models\Fee  $fee
     * @return void
     */
    public function updated(Fee $fee)
    {
        //
    }

    /**
     * Handle the Fee "deleted" event.
     *
     * @param  \App\Models\Fee  $fee
     * @return void
     */
    public function deleted(Fee $fee)
    {
        //
    }

    /**
     * Handle the Fee "restored" event.
     *
     * @param  \App\Models\Fee  $fee
     * @return void
     */
    public function restored(Fee $fee)
    {
        //
    }

    /**
     * Handle the Fee "force deleted" event.
     *
     * @param  \App\Models\Fee  $fee
     * @return void
     */
    public function forceDeleted(Fee $fee)
    {
        //
    }
}