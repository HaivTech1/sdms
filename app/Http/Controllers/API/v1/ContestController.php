<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Contest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\ContestResource;
use App\Http\Resources\v1\ContestCollection;

class ContestController extends Controller
{
    public function index(Request $request)
    {
        $pageSize = $request->page ?? 5;
        $limit = $request->limit ?? 5;
        return new ContestCollection(Contest::where('isAvailable', true)->first());
    }

    public function show(contest $contest)
    {
        return (new ContestResource($contest))
        ->response()
        ->setStatusCode(200);
    }
}