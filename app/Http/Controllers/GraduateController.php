<?php

namespace App\Http\Controllers;

use App\Models\Graduate;
use App\Http\Requests\StoreGraduateRequest;
use App\Http\Requests\UpdateGraduateRequest;

class GraduateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGraduateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGraduateRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Graduate  $graduate
     * @return \Illuminate\Http\Response
     */
    public function show(Graduate $graduate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Graduate  $graduate
     * @return \Illuminate\Http\Response
     */
    public function edit(Graduate $graduate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGraduateRequest  $request
     * @param  \App\Models\Graduate  $graduate
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGraduateRequest $request, Graduate $graduate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Graduate  $graduate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Graduate $graduate)
    {
        //
    }
}
