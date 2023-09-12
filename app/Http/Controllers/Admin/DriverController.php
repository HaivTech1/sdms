<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DriverController extends Controller
{
    
    public function index()
    {
        return view('admin.driver.index');
    }

    public function assignVehicle(Request $request)
    {
        try {
            $user = User::findOrFail($request->driver_id);
            $user->vehicleDriver()->attach($request->vehicle_id);

            return response()->json([
                'status' => true,
                'message' => "Vehicle assigned to driver successfully",
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}