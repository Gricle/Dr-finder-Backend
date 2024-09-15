<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Http\Requests\Rating\StoreRatingRequest;
use App\Http\Requests\Rating\UpdateRatingRequest;
use App\Http\Resources\RatingResource;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rating = Rating::all();
        return RatingResource::collection($rating);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRatingRequest $request)
    {
        $tourist = $request->user()->tourist;
        
        $rate = $tourist->rating()->create($request->validated());
    
        return new RatingResource($rate);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        
        $rating = Rating::findOrFail($id);
        return new RatingResource($rating);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRatingRequest $request, $id)
    {

        $rating = Rating::findOrFail($id);

        $tourist = $rating->tourist; 

        $updater = $request->user()->tourist->id ;

        if ($updater !== $tourist->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        $rating->update($request->validated());
    
        return new RatingResource($rating);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {

        $rating = Rating::with('tourist')->findOrFail($id);
        $tourist = $rating->tourist;
        $deleter = $request->user()->tourist->id;
        
        if ($deleter !== $tourist->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        $rating->delete();
     
        return response()->noContent(); 
    }


}