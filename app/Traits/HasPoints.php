<?php

namespace App\Traits;

use App\Models\Point;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasPoints
{
    public function awards($amount = null): MorphMany
    {
        return $this->morphMany(Point::class, 'pointable')
            ->orderBy('created_at', 'desc')
            ->take($amount);
    }

    public function countAwards()
    {
        return $this->awards()->count();
    }

    public function currentPoints()
    {
        return (new Point())->getCurrentPoints($this);
    }

    public function addPoints($amount, $message)
    {
        return (new Point())->addAwards($this, $amount, $message);
    }

    public function rank()
    {
        $currentPoints = $this->currentPoints();

        if ($currentPoints <= 100) {
            return 'Beginner';
        }

        if ($currentPoints <= 200) {
            return 'Amateur';
        }

        if ($currentPoints <= 500) {
            return 'Ultimate';
        }

        if ($currentPoints <= 1000) {
            return 'Master';
        }

        if ($currentPoints <= 2000) {
            return 'Professionalp';
        }
    }
}