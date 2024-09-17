<?php

namespace App\Http\Controllers\Api\Tourist;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use App\Http\Requests\Visit\StoreVisitRequest;
use App\Http\Resources\VisitResource;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $visits = Visit::all();

        return VisitResource::collection($visits);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVisitRequest $request)
    {
        $validatedData = $request->validated();
        
        $tourist_id = $request->user()->tourist->id;
    
        $visitDate = Carbon::parse($validatedData['visit_date']);
    
        if (Visit::isDoctorBusy($validatedData['doctor_id'], $visitDate)) {
            return response()->json([
                'message' => 'The doctor is busy during this time. Please choose another time.',
            ], 409);
        }
        $visit_price = Visit::getVisitPriceById($validatedData['doctor_id']);
        $visit = Visit::create([
            'tourist_id' => $tourist_id,          
            'doctor_id' => $validatedData['doctor_id'],
            'visit_date' => $validatedData['visit_date'],
            'price' => $visit_price
        ]);
    
        return response()->json([
            'message' => 'Visit created successfully!',
            'data' => new VisitResource($visit),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Visit $visit)
    {

        return new VisitResource($visit);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        $visit = Visit::findOrFail($id);
        $tourist = $visit->tourist;

        if ($request->user()->tourist->id !== $tourist->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        $visit->delete();
    
        return response()->noContent();
    }

}
