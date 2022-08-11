<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use App\Models\Contestant;
use App\Jobs\CreateContestant;
use App\Http\Requests\ContestantRequest;
use App\Http\Requests\StoreContestantRequest;
use App\Http\Requests\UpdateContestantRequest;

class ContestantController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'manager']);
    }
    
    public function index()
    {
        return view('ev.contestant.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('ev.contestant.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreContestantRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContestantRequest $request)
    {
        $this->dispatchSync(CreateContestant::fromRequest($request));
        
        $notification = array(
            'messege' => 'Contestant created successfully',
            'alert-type' => 'success',
            'title' => 'Successful!',
            'button' => 'Thanks, operation successful!',
        );

        return redirect()->route('contestant.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contestant  $contestant
     * @return \Illuminate\Http\Response
     */
    public function show(Contestant $contestant)
    {
        return view('ev.contestant.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contestant  $contestant
     * @return \Illuminate\Http\Response
     */
    public function edit(Contestant $contestant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateContestantRequest  $request
     * @param  \App\Models\Contestant  $contestant
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContestantRequest $request, Contestant $contestant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contestant  $contestant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contestant $contestant)
    {
        //
    }
}