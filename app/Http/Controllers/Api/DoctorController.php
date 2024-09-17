<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Http\Requests\Doctor\StoreDoctorRequest;
use App\Http\Requests\Doctor\UpdateDoctorRequest;
use App\Http\Resources\DoctorResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::all();
        return DoctorResource::collection($doctors);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDoctorRequest $request)
    {
        $user = User::create([

            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->doctor()->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'description' => $request->description,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'expertise' => $request->expertise,
            'address' => $request->address,
            'visit_price' => $request->visit_price
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
    public function show(Doctor $doctor)
    {
        return new DoctorResource($doctor);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDoctorRequest $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
        $user = $doctor->user;
    
        if ($request->user()->id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        $doctor->update($request->validated());
        $user->update($request->validated());
    
        return new DoctorResource($doctor);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        $doctor = Doctor::findOrFail($id);
        $user = $doctor->user;
    
        if ($request->user()->id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        $doctor->delete();
        $user->delete();
    
        return response()->noContent();
    }
}
