<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct()
    {
       $this->middleware(['admin', 'auth']);
    }

    public function index()
    {
        return view('admin.commerce.product');
    }

    public function orders()
    {
        return view('admin.commerce.orders');
    }

    public function userOrders()
    {
        return view('student.market.orders');
    }

    protected function parseSpec($data)
    {
        $parsed = [];
        $items = explode(',', $data);
        foreach ($items as $item) {
            $values = explode(':', $item);
            $splits = explode(' ', $values[1]);
            $parsed[$values[0]] = $splits;
        }
        return $parsed;
    }

    public function store(Request $request)
    {        
        try {
            $validate = Validator::make($request->all(),[
                "title" =>["required"],
                "price" =>["required"],
                "category_id" => ["required"],
            ]);

            if($validate->fails()){
                return response()->json([
                    'status' => false,
                    "message" => $validate->messages()->first()
                ], 500);
            }else{
                $product = new Product([
                    'title'                 => $request->title,
                    'price'                 => $request->price,
                    'status'                 => 1,
                    'quantity'              => $request->quantity,
                    'category_id'           => $request->category_id,
                    'description'           => $request->description,
                    'speculations'          => json_encode($this->parseSpec($request->speculations))
                ]);
        
                if($request->image){
                    $fileName = $request->image->getClientOriginalName();
                    $filePath = 'products/' . $fileName;
                    $isFileUploaded = Storage::disk('public')->put($filePath, file_get_contents($request->image));
            
                    if ($isFileUploaded) {
                        $product->image = $filePath;
                    }
                }
                $product->save();
            }

            return response()->json([
                'status' => true, 
                'message' => ['
                Product created Successfully!'
            ]], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status' => false,
                "message" => $th->getMessage()
            ], 500);
        }
    }

    public function update(Request $request)
    {        
        try {
            
            $product = Product::where('id', $request->product_id)->first();
            $product->update([
                'title'                 => $request->title,
                'price'                 => $request->price,
                'quantity'              => $request->quantity,
                'category_id'           => $request->category_id,
                'description'           => $request->description,
                'speculations'          => json_encode($this->parseSpec($request->speculations))
            ]);
    
            if($request->image){
                File::delete(storage_path('app/public/'.$product->image));
                $fileName = $request->image->getClientOriginalName();
                $filePath = 'products/' . $fileName;
                $isFileUploaded = Storage::disk('public')->put($filePath, file_get_contents($request->image));
        
                if ($isFileUploaded) {
                    $product->update(['image' => $filePath]);
                }
            }
            return response()->json([
                'status' => true, 
                'message' => ['
                Product updated Successfully!'
            ]], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                "message" => $th->getMessage()
            ], 500);
        }
    }
}