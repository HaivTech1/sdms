<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeneralController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'student']);
    }

    public function fees()
    {
        $user = auth()->user();
        $grade = $user->student->grade;
        $fees = Fee::where('grade_id', $grade->id)->select([
            'term_id',
            \DB::raw('COUNT(id) as types'),
            \DB::raw('SUM(price) as price'),
        ])
        ->groupBy('term_id')
        ->orderBy('term_id')
        ->get();

        // dd($fees);

        // $schoolFees = array();

        // foreach ($fees as $value) {
        //     foreach ($value as $get) {
        //         foreach ($get as $value) {
        //             $schoolFees[] = [
        //                 'title' => $value->title,
        //                 'term_id' => $value->term_id,
        //                 'period_id' => $value->period_id,
        //                 'price' => $value->price,
        //             ];
        //         }
        //     }
        // }

        return view('admin.student.fees',[
            'user' => $user,
            'fees' => $fees
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
}
