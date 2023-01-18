<?php

namespace App\Http\Controllers;

use App\Jobs\CreateFee;
use Illuminate\Http\Request;
use App\Http\Requests\FeeRequest;

class FeeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'bursal']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.fee.index');
    }

    public function create()
    {
        return view('admin.fee.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FeeRequest $request)
    {
        // dd($request);
        $this->dispatchSync(CreateFee::fromRequest($request));

        $notification = array (
            'messege' => 'Fee Created successfully',
            'alert-type' => 'success',
            'button' => 'Okay!',
            'title' => 'Success'
        );

        return redirect()->back()->with($notification);
    }
}