<?php

namespace App\Observers;

use App\Models\Term;
use App\Models\Period;
use App\Models\Payment;

class PaymentObserver
{
    public function creating(Payment $payment)
    {
        $period = Period::where('status', true)->first();
        $term = Term::where('status', true)->first();

        $payment->period_id = $period->id();
        $payment->term_id = $term->id();
    }
}