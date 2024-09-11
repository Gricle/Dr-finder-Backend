<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HotelResource;
use App\Models\Hotel;
use App\Http\Requests\Hotel\StoreHotelRequest;
use App\Http\Requests\Hotel\UpdateHotelRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hotels = Hotel::all();
        return HotelResource::collection($hotels);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHotelRequest $request)
    {
        $user = User::create([

            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->hotel()->create([
            'name' => $request->first_name,
            'stars' => $request->stars,
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
    public function show(Hotel $hotel)
    {
        return new HotelResource($hotel);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHotelRequest $request, $id)
    {
        $hotel = Hotel::findOrFail($id);
        $user = $hotel->user;
    
        if ($request->user()->id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        $hotel->update($request->validated());
        $user->update($request->validated());
    
        return new HotelResource($hotel);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        $hotel = Hotel::findOrFail($id);
        $user = $hotel->user;
    
        if ($request->user()->id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        $hotel->delete();
        $user->delete();
    
        return response()->noContent();
    }
}
