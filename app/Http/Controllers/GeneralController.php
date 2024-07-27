<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\Father;
use App\Models\Mother;
use App\Models\Student;
use App\Models\Guardian;
use Illuminate\Http\Request;
use App\Scopes\HasActiveScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GeneralController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'student'])->except(['motherUpdate', 'fatherUpdate', 'guardianUpdate', 'motherCreate', 'fatherCreate', 'guardianCreate']);
    }

    public function fees()
    {
        $user = auth()->user();
        $grade = $user->student->grade;
        // $fees = Fee::where([
        //     'grade_id' => $grade->id,
        //     'type' => $user->student->type,
        //     'term_id' => term('id')
        // ])->select([
        //     'term_id',
        //     \DB::raw('COUNT(id) as types'),
        //     \DB::raw('SUM(price) as price'),
        // ])
        // ->groupBy('term_id')
        // ->orderBy('term_id')
        // ->get();

        $getFee = Fee::where([
            'grade_id' => $grade->id,
            'type' => $user->student->type,
            'term_id' => term('id')
        ])->first();

        if ($getFee) {
            $sum = 0;
            $sum += $getFee->details->sum('price');

            $feesArray = [
                'price' => $sum,
                'term_id' => $getFee->term_id,
            ];
        }else{
            $feesArray = [];
        }

        return view('admin.student.fees',[
            'user' => $user,
            'fee' => $feesArray
        ]);
    }

    private function custom_array_merge($newResult, $newFirst) {
        $result = array();
        foreach ($newResult as $key_1 => $value_1) {
            foreach ($newFirst as $key_1 => $value_2) {
                if($value_1['term_id'] ==  $value_2['term_id'] && $value_1['period_id'] == $value_2['period_id']) {
                    $result[] = array_merge($value_1,$value_2);
                }
            }
    
        }
        return $result;
    }

    public function fatherUpdate(Request $request)
    {
        $student = Student::findOrfail($request->student_id);
        $exists = Father::where('student_uuid', $student->id())->first();

        if (!$exists){
            $father = new Father([
                'student_uuid' => $student->id(),
                'name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone_number,
                'occupation' => $request->occupation,
                'office_address' => $request->office_address,
            ]);
            $father->save();
        }else{
            $exists->update([
                'name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone_number,
                'occupation' => $request->occupation,
                'office_address' => $request->office_address,
            ]);
        }
       
        return response()->json(['status' => true, 'message' => 'Information successfully saved!']);
    }

    public function guardianUpdate(Request $request)
    {
        $student = Student::findOrfail($request->student_id);
        $exists = Guardian::where('student_id', $student->id())->first();

        if (!$exists){
            $guardian = new Guardian([
                'student_uuid' => $student->id(),
                'name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone_number,
                'occupation' => $request->occupation,
                'office_address' => $request->office_address,
            ]);
            $guardian->save();
        }else{
            $exists->update([
                'name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone_number,
                'occupation' => $request->occupation,
                'office_address' => $request->office_address,
            ]);
        }
       
        return response()->json(['status' => true, 'message' => 'Information successfully saved!']);
    }

    public function motherUpdate(Request $request)
    {
        $student = Student::findOrfail($request->student_id);
        $exists = Mother::where('student_uuid', $student->id())->first();

        if (!$exists){
            $mother = new Mother([
                'student_uuid' => $student->id(),
                'name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone_number,
                'occupation' => $request->occupation,
                'office_address' => $request->office_address,
            ]);
            $mother->save();
        }else{
            $exists->update([
                'name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone_number,
                'occupation' => $request->occupation,
                'office_address' => $request->office_address,
            ]);
        }
       
        return response()->json(['status' => true, 'message' => 'Information successfully saved!']);
    }

    public function parentDetails()
    {
        $motherDetails = Auth::user()->student->mother;
        $fatherDetails = Auth::user()->student->father;

        return view('student.parent.index',[
            'father' => $fatherDetails,
            'mother' => $motherDetails
        ]);
    }

    public function updateMotherData(Request $request)
    {
        try{

            $data = $request->all();
            $validatedData = Validator::validate($data, [
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'occupation' => 'required',
                'office_address' => 'required',
            ]);

            if(isset(auth()->user()->student->mother)){
                $mother = auth()->user()->student->mother->update($validatedData);
            }else{
                $mother = new Mother([
                    'student_uuid' => auth()->user()->student->uuid,
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'occupation' => $request->occupation,
                    'office_address' => $request->office_address,
                ]);
                $mother->save();
            }

            return response()->json([
                'status' => true,
                'message' => "Information updated successfully!",
                'data' => $mother
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function updateFatherData(Request $request)
    {
        try {

            $data = $request->all();
            $validatedData = Validator::validate($data, [
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'occupation' => 'required',
                'office_address' => 'required',
            ]);

            if (isset(auth()->user()->student->father)) {
                $father = auth()->user()->student->father->update($validatedData);
            } else {
                $father = new Father([
                    'student_uuid' => auth()->user()->student->uuid,
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'occupation' => $request->occupation,
                    'office_address' => $request->office_address,
                ]);
                $father->save();
            }

            return response()->json([
                'status' => true,
                'message' => "Information updated successfully!",
                'data' => $father
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
    
}
