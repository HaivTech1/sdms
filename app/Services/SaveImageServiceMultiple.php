<?php

namespace App\Services;

use Illuminate\Http\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class SaveImageServiceMultiple
{
    public static function UploadBatch($row, $image, $model, $folder)
    {
        $path = Storage::putFile($folder, new File($image));
        $targetPath = storage_path('app/public/' . $path);
        Image::make($image)->resize(1200, 650)->save($targetPath);
        $model->$row = $path;
        $model->save();
    }
}