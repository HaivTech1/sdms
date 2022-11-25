<?php

namespace App\Services;

use Illuminate\Http\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class SaveImageService
{
    public static function UploadImage($image, $model, $folder, $row)
    {
        $path = Storage::putFile($folder, new File($image));
        $targetPath = storage_path('app/' . 'public/' . $path);
        Image::make($image)->resize(1200, 630)->save($targetPath);
        $model->$row = $path;
        $model->save();
    }
}