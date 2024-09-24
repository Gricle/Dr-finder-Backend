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
    public function index()
    {
        $ratings = Rating::all();
        return RatingResource::collection($ratings);
    }

    public function store(StoreRatingRequest $request)
    {
        $tourist = $request->user()->tourist;
        $rate = $tourist->rating()->create($request->validated());
        return new RatingResource($rate);
    }

    public function show($id)
    {
        $rating = Rating::findOrFail($id);
        return new RatingResource($rating);
    }

    public function update(UpdateRatingRequest $request, $id)
    {
        $rating = Rating::findOrFail($id);
        $this->authorize('update', $rating);
        
        $rating->update($request->validated());
        return new RatingResource($rating);
    }

    public function destroy($id, Request $request)
    {
        $rating = Rating::with('tourist')->findOrFail($id);
        $this->authorize('delete', $rating);
        
        $rating->delete();
        return response()->noContent(); 
    }
}