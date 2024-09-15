<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tourist;
use App\Http\Requests\Tourist\StoreTouristRequest;
use App\Http\Requests\Tourist\UpdateTouristRequest;
use App\Http\Resources\TouristResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TouristController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tourist = Tourist::all();
        return TouristResource::collection($tourist);
    }

    /**
     * Store a newly created resource in storage.
     */
    
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

    /**
     * Display the specified resource.
     */
    public function show(Tourist $tourist)
    {
        return new TouristResource($tourist);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTouristRequest $request, $id)
    {
        $tourist = Tourist::findOrFail($id);
        $user = $tourist->user;
    
        if ($request->user()->id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        $tourist->update($request->validated());
        $user->update($request->validated());
    
        return new TouristResource($tourist);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        $tourist = Tourist::findOrFail($id);
        $user = $tourist->user;
    
        if ($request->user()->id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        $tourist->delete();
        $user->delete();
    
        return response()->noContent();
    }
}
