<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
class PromotionController extends Controller
{
    public function __construct()
    {
       $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        return view('admin.student.promotion');
    }
}
