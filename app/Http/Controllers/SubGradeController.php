<?php

namespace App\Http\Controllers;

use App\Models\SubGrade;
use Illuminate\Http\Request;

class SubGradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.subgrade.index');
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubGrade  $subGrade
     * @return \Illuminate\Http\Response
     */
    public function show(SubGrade $subGrade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubGrade  $subGrade
     * @return \Illuminate\Http\Response
     */
    public function edit(SubGrade $subGrade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubGrade  $subGrade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubGrade $subGrade)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubGrade  $subGrade
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubGrade $subGrade)
    {
        //
    }
}
