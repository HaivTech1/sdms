<?php

namespace App\Http\Controllers;

use App\Models\Affective;
use App\Http\Requests\StoreAffectiveRequest;
use App\Http\Requests\UpdateAffectiveRequest;

class AffectiveController extends Controller
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
     * @param  \App\Http\Requests\StoreAffectiveRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAffectiveRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Affective  $affective
     * @return \Illuminate\Http\Response
     */
    public function show(Affective $affective)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Affective  $affective
     * @return \Illuminate\Http\Response
     */
    public function edit(Affective $affective)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAffectiveRequest  $request
     * @param  \App\Models\Affective  $affective
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAffectiveRequest $request, Affective $affective)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Affective  $affective
     * @return \Illuminate\Http\Response
     */
    public function destroy(Affective $affective)
    {
        //
    }
}
