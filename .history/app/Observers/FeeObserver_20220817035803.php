<?php

namespace App\Observers;

use App\Models\Fee;

class FeeObserver
{
    /**
     * Handle the Fee "created" event.
     *
     * @param  \App\Models\Fee  $fee
     * @return void
     */
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
