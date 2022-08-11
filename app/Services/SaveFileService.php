<?php

namespace App\Services;

use Illuminate\Http\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class SaveFileService
{
    public static function uploadFile($row, $file, $model, $folder)
    {
        $path = Storage::putFile('public/' .$folder, new File($file));
        $storagePath = storage_path('app/public/'. $path);
        $model->$row = $path;
        $model->save();
    }
}

