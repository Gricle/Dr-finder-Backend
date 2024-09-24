<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fly;
use App\Http\Requests\Fly\StoreFlyRequest;
use App\Http\Requests\Fly\UpdateFlyRequest;
use App\Http\Resources\FlyResource;
use Illuminate\Http\Request;

class FlyController extends Controller
{
    public function index()
    {
        $flies = Fly::all();
        return FlyResource::collection($flies);
    }

    public function store(StoreFlyRequest $request)
    {
        $airport = $request->user()->airport;
        $fly = $airport->fly()->create($request->validated());

        return response()->json([
            'message' => 'Flight created successfully!',
            'fly' => new FlyResource($fly)
        ], 201);
    }

    public function show(Fly $fly)
    {
        return new FlyResource($fly);
    }

    public function update(UpdateFlyRequest $request, Fly $fly)
    {
        $this->authorize('update', $fly);
        
        $fly->update($request->validated());
    
        return new FlyResource($fly);
    }

    public function destroy(Fly $fly, Request $request)
    {
        $this->authorize('delete', $fly);
        
        $fly->delete();
     
        return response()->noContent();
    }
}