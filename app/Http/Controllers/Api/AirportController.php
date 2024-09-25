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
    public function index()
    {
        $airports = Airport::all();
        return AirportResource::collection($airports);
    }

    public function store(StoreAirportRequest $request)
    {
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $airport = $user->airport()->create($request->validated());

        $user->sendEmailVerificationNotification();

        return response()->json([
            'status' => true,
            'message' => 'User registered successfully! Please check your email for verification.',
            'token' => $user->createToken("API TOKEN")->plainTextToken,
            'data' => new AirportResource($airport),
        ], 201);
    }

    public function show(Airport $airport)
    {
        return new AirportResource($airport);
    }

    public function update(UpdateAirportRequest $request, Airport $airport)
    {
        $this->authorize('update', $airport);
        $airport->update($request->validated());
        return new AirportResource($airport);
    }

    public function destroy(Airport $airport, Request $request)
    {
        $this->authorize('delete', $airport);
        $airport->delete();
        return response()->noContent();
    }
}