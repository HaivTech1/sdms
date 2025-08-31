<?php
namespace App\Cast;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class TimeCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return $value ? Carbon::createFromFormat('H:i:s', $value) : null;
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if ($value instanceof Carbon) {
            return $value->format('H:i:s');
        }

        return $value;
    }
}
