<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Registration;
use Illuminate\Http\Request;
use App\Scopes\HasActiveScope;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\RegistrationResource;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $grade = $request->grade;
        $search = $request->search;

        $registrations = Registration::withoutGlobalScope(new HasActiveScope)->when($grade, function($query, $grade) {
            $query->whereHas('grade', function($query) use ($grade){
               $query->where('id', $grade);
            });
        })
        ->where('status', false)
        ->search(trim($search))->get();
    
        return response()->json(['status' => true, 'registrations' => RegistrationResource::collection($registrations)]);
    }

    public function single($id)
    {
        $registration = Registration::findOrFail($id);
        return response()->json(['status' => true, 'registration' => new RegistrationResource($registration)], 200);
    }
}
