<?php

namespace App\Services;

use Illuminate\Support\Str;

class SaveCode
{

    public static function Generator($int, $count, $row, $model)
    {
        $code = $int.''. date('y') . '/'. str_pad(random_int(100000, 999999), $count, "5", STR_PAD_LEFT);

        $check = $model::where($row, $code)->exists();

        if ($check) {
            return Generator();
        }

        return $code;
    }

    public static function GeneratorPin($count, $row, $model)
    {
        $code = str_pad(Str::random($count), $count, "5", STR_PAD_LEFT);

        $check = $model::where($row, $code)->exists();

        if ($check) {
            return Generator();
        }

        return $code;
    }
}