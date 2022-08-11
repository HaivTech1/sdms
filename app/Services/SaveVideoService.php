<?php

namespace App\Services;

use Illuminate\Http\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class SaveVideoService
{
    public static function UploadVideo($row, $video, $model, $folder)
    {
        $path = Storage::putFile('public/' .$folder, new File($video));
        $storagePath = storage_path('app/public/'. $path);
        $model->$row = $path;
        $model->save();
    }
}

