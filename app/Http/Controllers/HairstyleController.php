<?php

namespace App\Http\Controllers;

use App\Models\Hairstyle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HairstyleController extends Controller
{
    public function __construct()
    {
        return $this->middleware(['auth', 'admin']);
    }

    public function store(Request $request)
    {
        $status = $request->get('status') === 'on' ? 1 : 0;
        try {
            $hairstyle = new Hairstyle([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $status,
            ]);

            if($request->hasFile('front_view')){
                $fileName = $request->front_view->getClientOriginalName();
                $filePath = 'hairstyles/' . $fileName;
                $isFileUploaded = Storage::disk('public')->put($filePath, file_get_contents($request->front_view));
        
                if ($isFileUploaded) {
                    $hairstyle->front_view = $filePath;
                }
            }

            if($request->hasFile('back_view')){
                $fileName = $request->back_view->getClientOriginalName();
                $filePath = 'hairstyles/' . $fileName;
                $isFileUploaded = Storage::disk('public')->put($filePath, file_get_contents($request->back_view));
        
                if ($isFileUploaded) {
                    $hairstyle->back_view = $filePath;
                }
            }

            if($request->hasFile('side_view')){
                $fileName = $request->side_view->getClientOriginalName();
                $filePath = 'hairstyles/' . $fileName;
                $isFileUploaded = Storage::disk('public')->put($filePath, file_get_contents($request->side_view));
        
                if ($isFileUploaded) {
                    $hairstyle->side_view = $filePath;
                }
            }


            if ($hairstyle->save()) {
                // return response()->json(['status' => true, 'message' => 'Hairstyle created successfully!'], 200);
                $notification = array (
                    'messege' => 'Hair style created successfully',
                    'alert-type' => 'success',
                    'button' => 'Okay!',
                    'title' => 'Success'
                );
                return redirect()->back()->with($notification);
            }
        } catch (\Throwable $th) {
            // return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
            $notification = array (
                'messege' => $th->getMessage(),
                'alert-type' => 'error',
                'button' => 'Okay!',
                'title' => 'Failed'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function show($id)
    {
        $hairstyle = Hairstyle::findOrFail($id);
        return response()->json($hairstyle);
    }
}
