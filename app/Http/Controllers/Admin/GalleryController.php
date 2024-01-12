<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Services\SaveImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['admin']);
    }

    public function index()
    {
        $title = "Gallery";
        $galleries = Gallery::paginate(20);
        return view('admin.frontend.gallery.index', [
            'title' => $title,
            'galleries' => $galleries
        ]);
    }

    public function store(Request $request)
    {
        try {

            $data = $request->all();
            $validatedData  = Validator::make($data, [
                'title' => ['required'],
                'image' => ['required'],
            ],[
                "title" => "Image title is required",
                "image" => "Image is required",
            ]);

            if ($validatedData->fails()) {
                $error = "";
                foreach ($validatedData->errors()->all() as $value) {
                    $error .= $value;
                }

                return response()->json([
                    'message' => $error
                ], 500);
            }

            $gallery = new Gallery([
                'title' => $request->title
            ]);

            SaveImageService::UploadImage($request->image, $gallery, Gallery::TABLE, 'image');

            return response()->json([
                'status' => true,
                'message' => 'Image created successfully.',
            ], 201);
        } catch (\Throwable $th) {
            info($th->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'There was an error creating the image',
            ], 500);
        }
    }

    public function destroy(Gallery $gallery)
    {
        try{
            $gallery->delete();
            return response()->json([
                'status' => true,
                'message' => 'Image deleted successfully'
            ], 200);
        }catch(\Throwable $th){
            info(`Image deletion error: ${$th->getMessage()}`);
            return response()->json([
                'status' => true,
                'message' => 'There was an error deleting the image'
            ], 500);
        }
    }

    public function destroyMany(Request $request)
    {
        
        try{
            $ids = [];
            foreach($request->ids as $value){
                $ids[] = $value;
            }

            Gallery::whereIn('id', $ids)->delete();
            return response()->json([
                'status' => true,
                'message' => 'All images deleted successfully'
            ], 200);
        }catch(\Throwable $th){
            info(`Image deletion error: ${$th->getMessage()}`);
            return response()->json([
                'status' => true,
                'message' => 'There was an error deleting the images'
            ], 500);
        }
    }
}