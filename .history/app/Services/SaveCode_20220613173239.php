<?php

namespace App\Services;

class SaveCode
{

    public static function Generator($table, $model, $trow)
    {
        $data = $table::orderBy('id', 'desc')->first();
        $model->$trow = '#trk'.str_pad($data->id + 1, 8, "0", STR_PAD_LEFT);
        $model->save();
    }

}





