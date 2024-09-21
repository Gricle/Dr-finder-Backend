<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Http\Requests\Doctor\StoreDoctorRequest;
use App\Http\Requests\Doctor\UpdateDoctorRequest;
use App\Http\Resources\DoctorResource;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Doctor::query();
    
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('first_name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('expertise', 'LIKE', "%{$searchTerm}%");
            });
        }
        if ($request->has('sort_by') && in_array($request->sort_by, ['first_name', 'expertise'])) {
            $sortOrder = $request->has('sort_order') && $request->sort_order === 'desc' ? 'desc' : 'asc';
            $query->orderBy($request->sort_by, $sortOrder);
        }
    
        $doctors = $query->get();
    
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

    public function getDoctorVisits($doctorID)
    {
        $doctor = Doctor::findOrFail($doctorID);
        $visits = Visit::where('doctor_id', $doctor->id)->get();
        if ($visits->isEmpty()) {
            return response()->json([
                'message' => 'No visits found for this doctor.'
            ], 404);
        }
        
        return response()->json([
            'doctor' => $doctor,
            'visits' => $visits
        ]);
    }
}