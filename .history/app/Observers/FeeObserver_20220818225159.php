<?php

namespace App\Observers;

use App\Models\Fee;
use App\Models\Term;
use App\Models\Period;

class FeeObserver
{
    public function creating(Fee $fee)
    {
        $period = Period::where('status', true)->first();
        $term = Term::where('status', true)->first();

        $fee->period_id = $period->id();
        $fee->term_id = $term->id();
    }
}