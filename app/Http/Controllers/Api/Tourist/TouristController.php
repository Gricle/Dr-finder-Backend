<?php

namespace App\Http\Controllers\Api\Tourist;

use App\Helpers\DistanceHelper;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Tourist;
use App\Http\Requests\Tourist\StoreTouristRequest;
use App\Http\Requests\Tourist\UpdateTouristRequest;
use App\Http\Resources\TouristResource;
use App\Models\Doctor;
use App\Models\Hotel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TouristController extends Controller
{
    public function index()
    {
        $tourists = Tourist::all();
        return TouristResource::collection($tourists);
    }

    public function store(StoreTouristRequest $request)
    {
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->tourist()->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'national_code' => $request->national_code,
            'number' => $request->number,
            'birth_date' => $request->birth_date,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User registered successfully',
            'token' => $user->createToken("API TOKEN")->plainTextToken,
        ], 201);
    }

    public function show(Tourist $tourist)
    {
        return new TouristResource($tourist);
    }

    public function update(UpdateTouristRequest $request, Tourist $tourist)
    {
        $this->authorize('update', $tourist);
        
        $tourist->update($request->validated());
        
        return new TouristResource($tourist);
    }

    public function destroy(Tourist $tourist, Request $request)
    {
        $this->authorize('delete', $tourist);
        
        $tourist->delete();
        
        return response()->noContent();
    }

    public function touristActivities($touristID)
    {
        $tourist = DB::table('tourists')->where('id', $touristID)->first();
    
        if (!$tourist) {
            return response()->json(['message' => 'Tourist not found'], 404);
        }
    
        $tickets = DB::table('tickets')
            ->where('tourist_id', $touristID)
            ->select('id', 'fly_id', 'seat_number', 'created_at as date')
            ->get();
    
        $visits = DB::table('visits')
            ->where('tourist_id', $touristID)
            ->select('id', 'doctor_id', 'visit_date as date', 'price')
            ->get();

        $reserves = DB::table('reservations')
            ->where('tourist_id', $touristID)
            ->select('id','room_id','total_price','check_in','check_out')
            ->get();

        $activities = collect();
        $activities = $activities->merge($tickets);
        $activities = $activities->merge($visits);
        $activities = $activities->merge($reserves);
    
        return response()->json([
            'tourist' => $tourist,
            'activities' => $activities->sortBy('id'),
        ]);
    }

    public function calculateDistance(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'hotel_id' => 'required|exists:hotels,id',
        ]);
    
        $doctor = Doctor::findOrFail($request->doctor_id);
        $hotel = Hotel::findOrFail($request->hotel_id);

        return response()->json([
            'distance' => round(DistanceHelper::calculateDistance(
                $doctor->latitude, 
                $doctor->longitude, 
                $hotel->latitude, 
                $hotel->longitude), 2),
            'unit' => 'km',
        ]);
    }
}