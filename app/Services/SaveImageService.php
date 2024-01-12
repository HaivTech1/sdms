<?php

namespace App\Services;

use Illuminate\Http\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class SaveImageService
{
    public static function UploadImage($image, $model, $folder, $row)
    {
        $path = Storage::putFile('public/' . $folder, new File($image));
        $path = str_replace('public/', '', $path);
        $targetPath = storage_path('app/public/' . $path);
        Image::make($image)->resize(1200, 750)->save($targetPath);
        $model->$row = $path;
        $model->save();
    }
}