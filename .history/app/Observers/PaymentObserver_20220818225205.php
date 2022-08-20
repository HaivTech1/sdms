<?php

namespace App\Observers;

class PaymentObserver
{
    public function creating(Fee $fee)
    {
        $period = Period::where('status', true)->first();
        $term = Term::where('status', true)->first();

        $fee->period_id = $period->id();
        $fee->term_id = $term->id();
    }
}