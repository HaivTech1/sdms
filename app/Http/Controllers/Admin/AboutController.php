<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Services\SaveImageService;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $title = "Website About Settings";
        // $model_name = app("App\Models\\$title");
        // $columns = $model_name->column();
        $website_settings = About::all();

        return view('admin.frontend.about.index', [
            'title' => $title,
            'settings' => $website_settings
        ]);
    }

    public function store(Request $request)
    {
        try {
            $newAbout = new About([
                'name' => $request->name,
                'description' => $request->description,
                'input_type' => $request->input_type,
                'column_name' => $request->column_name,
                'model' => $request->model,
            ]);

            if ($request->hasFile('value')) {
                 SaveImageService::UploadImage($request->value, $newAbout, About::TABLE, 'value');
            }else{
                $newAbout->value = $request->value;
                $newAbout->save();
            }

            return response()->json([
                'status' => true,
                'message' => 'Created successfully.'
            ], 200);
        } catch (\Throwable $th) {
           return response()->json(error_processor(500, $th->getMessage()), 500);
        }
    }

    public function update(Request $request)
    {

        try {
            $key = $request->key;
            $value = $request->value;

            $setting = About::whereColumn_name($key)->first();

            if ($request->hasFile('value')) {
                SaveImageService::UploadImage($request->value, $setting, About::TABLE, 'value');
            }else{
                $setting->update([
                    'value' => $value,
                ]); 
            }

            return response()->json([
                'status' => true,
                'message' => $key.' updated successfully to '.$value,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json(error_processor(500, $th->getMessage()), 500);
        }
    }
    
}
