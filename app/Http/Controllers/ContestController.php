<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use App\Jobs\CreateContest;
use App\Http\Requests\ContestRequest;
use App\Http\Requests\StoreContestRequest;
use App\Http\Requests\UpdateContestRequest;

class ContestController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'manager']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ev.contest.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ev.contest.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreContestRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContestRequest $request)
    {
        $this->dispatchSync(CreateContest::fromRequest($request));

        $notification = array(
            'messege' => 'Contest created successfully',
            'alert-type' => 'success',
            'title' => 'Successful!',
            'button' => 'Thanks, operation successful!',
        );

        return redirect()->route('contest.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contest  $contest
     * @return \Illuminate\Http\Response
     */
    public function show(Contest $contest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contest  $contest
     * @return \Illuminate\Http\Response
     */
    public function edit(Contest $contest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateContestRequest  $request
     * @param  \App\Models\Contest  $contest
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContestRequest $request, Contest $contest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contest  $contest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contest $contest)
    {
        //
    }
}