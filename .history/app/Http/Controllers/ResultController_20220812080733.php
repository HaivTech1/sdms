<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Jobs\CreateResult;
use App\Jobs\CreateSingleResult;
use App\Http\Requests\StoreResultRequest;
use App\Http\Requests\SingleResultRequest;
use App\Http\Requests\UpdateResultRequest;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.result.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.result.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreResultRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreResultRequest $request)
    {
        // dd($request);
        $this->dispatchSync(CreateResult::fromRequest($request));

        $notification = array (
            'messege' => 'Result uploaded successfully',
            'alert-type' => 'success',
            'button' => 'Okay!',
            'title' => 'Success'
        );

        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */

    public function show(Result $result)
    {
        //
    }

    public function singleUpload()
    {
        return view('admin.result.singleUpload');
    }

    public function storeSingleUpload(SingleResultRequest $request)
    {
        $checck = Result::where('period_id', $request->period_id)->where('term_id', $request->term_id)=>where('grade_id', $request->grade_id)->where('student_id', $request->student_id)->first();
        // dd($request);

        if ($check) {
            
            $notification = array (
                'messege' => 'Result for this student already exists',
                'alert-type' => 'error',
                'button' => 'Okay!',
                'title' => 'Sorry'
            );
    
            return redirect()->back()->with($notification);
        }else {
            $this->dispatchSync(CreateSingleResult::fromRequest($request));

            $notification = array (
                'messege' => 'Result uploaded successfully',
                'alert-type' => 'success',
                'button' => 'Okay!',
                'title' => 'Success'
            );

            return redirect()->back()->with($notification);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function edit(Result $result)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateResultRequest  $request
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateResultRequest $request, Result $result)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function destroy(Result $result)
    {
        //
    }
}