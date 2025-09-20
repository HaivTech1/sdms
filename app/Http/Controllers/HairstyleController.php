<?php

namespace App\Http\Controllers;

use App\Models\Hairstyle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HairstyleController extends Controller
{
    public function __construct()
    {
        return $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $hairstyles = Hairstyle::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.hairstyle.index', compact('hairstyles'));
    }

    public function list(Request $request)
    {
        $hairstyles = Hairstyle::orderBy('created_at', 'desc')->paginate(20);
        // if AJAX, return the partial HTML used by the admin list wrapper
        if ($request->ajax()) {
            return view('admin.hairstyle._hairstyles_list', compact('hairstyles'));
        }

        // fallback: return full view
        return view('admin.hairstyle.index', compact('hairstyles'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'title' => 'required|string|unique:hairstyles,title',
            'description' => 'nullable|string',
            'front_view' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'back_view' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'side_view' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'front_view.required' => 'The front view image is required.',
            'back_view.required' => 'The back view image is required.',
            'side_view.required' => 'The side view image is required.',
        ]);
        
        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
            }
        }

        try {
            $hairstyle = new Hairstyle([
                'title' => $request->title,
                'description' => $request->description,
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
                if ($request->ajax()) {
                    return response()->json(['status' => true, 'message' => 'Hairstyle created successfully!'], 200);
                }

                $notification = array (
                    'messege' => 'Hair style created successfully',
                    'alert-type' => 'success',
                    'button' => 'Okay!',
                    'title' => 'Success'
                );
                return redirect()->back()->with($notification);
            }
        } catch (\Throwable $th) {
            if ($request->ajax()) {
                return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
            }

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

    public function all()
    {
        $hairstyles = Hairstyle::orderBy('title')->get();
        $data = $hairstyles->map(function($h){
            return [
                'id' => $h->id,
                'title' => $h->title,
                'front' => $h->front_view ? asset('storage/' . $h->front_view) : asset('noImage.png'),
                'side' => $h->side_view ? asset('storage/' . $h->side_view) : asset('noImage.png'),
                'back' => $h->back_view ? asset('storage/' . $h->back_view) : asset('noImage.png'),
            ];
        });

        return response()->json(['status' => true, 'data' => $data]);
    }

    public function destroy($id)
    {
        $hairstyle = Hairstyle::findOrFail($id);
        if ($hairstyle->delete()) {
            return response()->json(['status' => true, 'message' => 'Hairstyle deleted successfully!'], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed to delete hairstyle!'], 500);
        }
    }
}
