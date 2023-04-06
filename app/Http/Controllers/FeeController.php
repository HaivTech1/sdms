<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Jobs\CreateFee;
use App\Models\FeeDetail;
use Illuminate\Http\Request;
use App\Http\Requests\FeeRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FeeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'bursal']);
    }
    
    public function index()
    {
        return view('admin.fee.index');
    }

    public function create()
    {
        return view('admin.fee.create');
    }

    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'grade_id' => 'required',
                'term_id' => 'required',
                'addmore.*.title' => 'required',
                'addmore.*.price' => 'required',
            ]);

            if($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->all(),
                ], 500);
            }else{
                DB::transaction(function() use ($request) {
                    $fee = new Fee([
                        'grade_id' => $request->grade_id,
                        'term_id' => $request->term_id,
                        'type' => $request->type,
                    ]);
                    $fee->authoredBy(auth()->user());
                    $fee->save();
    
                    foreach ($request->addmore as $key => $value) {
                        $details = FeeDetail::create([
                            'fee_id' => $fee->id,
                            'title' => $value['title'],
                            'price' => $value['price'],
                        ]);
                    }
                });
            }
            return response()->json([
                'status' => true,
                'message' => 'Fee created successfully!'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'grade_id' => 'required',
                'term_id' => 'required',
                'type' => 'required',
            ]);
        
            if ($validator->fails()) {
                return response()->json(['status' =>  false, 'message' => $validator->errors()->all()], 500);
            }
        
            DB::transaction(function () use ($request){
                $fee = Fee::findOrFail($request->fee_id);
                $fee->update([
                    'grade_id' => $request->grade_id,
                    'term_id' => $request->term_id,
                    'type' => $request->type
                ]);

                $addmore = $request->input('addmore');

                if(!empty($addmore)) {
                    foreach($addmore as $row) {
                        if(isset($row['id'])) {
                            $detail = FeeDetail::findOrFail($row['id']);
                            $detail->title = $row['title'];
                            $detail->price = $row['price'];
                            $detail->save();
                        } else {
                            $detail = new FeeDetail;
                            $detail->title = $row['title'];
                            $detail->price = $row['price'];
                            $detail->fee_id = $fee->id();
                            $detail->save();
                        }
                    }
                }
            });

            return response()->json([
                'status' => true,
                'message' => 'Fee updated successfully!'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}