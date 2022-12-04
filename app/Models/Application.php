<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Application extends Model
{
    use HasFactory;

    const TABLE = 'applications';
    protected $table = self::TABLE;

    protected $fillable = [
        'name',
        'alias',
        'regNo',
        'email',
        'line1',
        'line2',
        'image',
        'fav',
        'slogan',
        'motto',
        'address',
        'logistic',
        'cleaning',
        'description',
        'facebook',
        'instagram',
        'twitter',
        'linkedin',
        'website'
    ];

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function alias(): string
    {
        return $this->alias;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function line1(): string
    {
        return $this->line1;
    }

    public function line2(): string
    {
        return $this->line2;
    }

    public function image(): ?string
    {
        return $this->image;
    }

    public function slogan(): string
    {
        return $this->slogan;
    }

    public function motto(): string
    {
        return $this->motto;
    }

    public function address(): string
    {
        return $this->address;
    }

    public function logistic(): int
    {
        return $this->logistic;
    }

    public function cleaning(): int
    {
        return $this->cleaning;
    }
    public function reg(): string
    {
        return $this->regNo;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function getImageUrlAttribute()
    {
        if ($this->image && Storage::disk('applications')->exists($this->image)) {

            return 'storage/'.$this->image;
        }
        return asset('default.png');
    }

    public static function findName(Array $names){
        $newNames = [];
        foreach ($names as $name){
          $setting = self::where('name', $name)->first();
          if ($setting) {
          $newNames[$name] = $setting->value;
          }
        }
        return $newNames;
      }
  
      public static function uploadLogo(Request $request){
        $image_name = 'logo.png'; // default logo image
        if ($request->hasFile('photo'))
        {
            $image = $request->file('photo');
            $input['imagename'] = $image_name;
  
            $destinationPath = public_path('/images');
  
            $image->move($destinationPath, $input['imagename']);
  
            $image_name = $input['imagename'];
  
            $setting = self::getOneSetting('logo');
  
            if (!$setting) {
              $setting = new self();
              $setting->name = 'logo';
            }
  
            $setting->value = $image_name;
            $setting->save();
            return response()->json(['status' => true,]);
        }
        return response()->json(['status' => false, 'text' => "No photo file"]);
      }
  
      public static function saveAppDetail(Request $request){
        $name = $request->name;
        if ($name)
        {
          $setting = self::getOneSetting('name');
  
          if (!$setting) {
            $setting = new self();
            $setting->name = $request->name;
            $setting->alias         = $request->alias;
            $setting->email         = $request->email;
            $setting->line1        = $request->line1;
            $setting->line2         = $request->line2;
            $setting->slogan         = $request->slogan;
            $setting->motto         = $request->motto;
            $setting->address         = $request->address;
            $setting->description         = $request->description;
          }

          $fileName = $request->logo->getClientOriginalName();
          $filePath = 'applications/' . $fileName;
          $isFileUploaded = Storage::disk('public')->put($filePath, file_get_contents($request->logo));
  
          if ($isFileUploaded) {
              $setting->image = $filePath;
          }

          $fileNameFav = $request->fav->getClientOriginalName();
          $filePathFav = 'applications/' . $fileNameFav;
          $isFileUploadedFav = Storage::disk('public')->put($filePathFav, file_get_contents($request->fav));
  
          if ($isFileUploadedFav) {
              $setting->fav = $filePathFav;
          }
    
          $setting->save();
          return response()->json(['status' => true, 'message' => "Details saved successfully!"]);
        }
        return response()->json(['status' => false, 'message' => "No Name set"]);
      }

    public static function getOneSetting(){
        return self::first();
    }

    public static function notSet(){
        return !self::getOneSetting();
      }
}