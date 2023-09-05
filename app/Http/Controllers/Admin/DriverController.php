<?php

namespace App\Http\Controllers\Admin;

use App\Models\user;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DriverController extends Controller
{
    
    public function index()
    {
        return view('admin.driver.index');
    }

    public function addVehicle($user, $vehicle)
    {
        try {
            $vehicle = new Vehicle([
                'name' => $request->get('name'),
                'plate_no' => $request->get('plate_no'),    
                'seats' => $request->get('seats'),
                'type' =>$request->get('type'),  
            ]);
            $vehicle->save();

            return response()->json([
                'status' => true,
                'message' => "Vehicle added successfully",
            ], 500);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}