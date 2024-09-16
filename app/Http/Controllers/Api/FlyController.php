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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $flies = Fly::all();
        return FlyResource::collection($flies);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFlyRequest $request)
    {
    $airport = $request->user()->airport;
    $fly = $airport->fly()->create($request->validated());

    return response()->json([
        'message' => 'Flight created successfully!',
        'fly' => new FlyResource($fly)
    ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Fly $fly)
    {
        return new FlyResource($fly);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFlyRequest $request, $id)
    {

        $fly = Fly::findOrFail($id);

        $airport = $fly->airport; 

        $updater = $request->user()->airport->id ;

        if ($updater !== $airport->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        $fly->update($request->validated());
    
        return new FlyResource($fly);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {

        $fly = Fly::with('airport')->findOrFail($id);
        $airport = $fly->airport;
        $deleter = $request->user()->airport->id;
        
        if ($deleter !== $airport->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        $fly->delete();
     
        return response()->noContent();
    }
}