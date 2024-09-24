<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Http\Requests\Doctor\StoreDoctorRequest;
use App\Http\Requests\Doctor\UpdateDoctorRequest;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\VisitResource;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
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

    public function store(StoreDoctorRequest $request)
    {
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        $doctor = $user->doctor()->create($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'User registered successfully',
            'token' => $user->createToken("API TOKEN")->plainTextToken,
            'data' => new DoctorResource($doctor),
        ], 201);
    }

    public function show(Doctor $doctor)
    {
        return new DoctorResource($doctor);
    }

    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        $this->authorize('update', $doctor);
        
        $doctor->update($request->validated());
        
        return new DoctorResource($doctor);
    }

    public function destroy(Doctor $doctor, Request $request)
    {
        $this->authorize('delete', $doctor);
        
        $doctor->delete();
        
        return response()->noContent();
    }

    public function getDoctorVisits($doctorID)
    {
        $doctor = Doctor::findOrFail($doctorID);
        
        if ($this->authorize('view', $doctor)) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }
        
        $visits = Visit::where('doctor_id', $doctorID)->get();
        
        if ($visits->isEmpty()) {
            return response()->json(['message' => 'No visits found for this doctor.'], 404);
        }
        
        return response()->json(['doctor' => new DoctorResource($doctor), 'visits' => VisitResource::collection($visits)]);
    }
}