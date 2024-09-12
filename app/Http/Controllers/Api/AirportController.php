<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Airport;
use App\Http\Requests\Airport\StoreAirportRequest;
use App\Http\Requests\Airport\UpdateAirportRequest;
use App\Http\Resources\AirportResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AirportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $airlines = Airport::all();
        
        return AirportResource::collection($airlines);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAirportRequest $request)
    {
        $user = User::create([

            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->airport()->create([
            'name' => $request->name,
            'description' => $request->description,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'address' => $request->address,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'User registered successfully',
            'token' => $user->createToken("API TOKEN")->plainTextToken,
         
        ], 201);
        
    } 

    /**
     * Display the specified resource.
     */
    public function show(Airport $airport)
    {
        return new AirportResource($airport);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAirportRequest $request, $id)
    {
        $airport = Airport::findOrFail($id);
        $user = $airport->user;
    
        if ($request->user()->id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        $airport->update($request->validated());
        $user->update($request->validated());
    
        return new AirportResource($airport);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        $airport = Airport::findOrFail($id);
        $user = $airport->user;
    
        if ($request->user()->id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        $airport->delete();
        $user->delete();
    
        return response()->noContent();
    }
}
