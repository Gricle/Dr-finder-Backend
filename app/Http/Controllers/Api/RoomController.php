<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Http\Requests\Room\StoreRoomRequest;
use App\Http\Requests\Room\UpdateRoomRequest;
use App\Http\Resources\RoomResource;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::all();
        return RoomResource::collection($rooms);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomRequest $request)
    {
        $hotel = $request->user()->hotel;
        $room = $hotel->room()->create($request->validated());
    
        return response()->json([
            'message' => 'room created successfully!',
            'room' => new RoomResource($room)
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        return new RoomResource($room);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomRequest $request, $id)
    {

        $room = Room::findOrFail($id);

        $hotel = $room->hotel; 

        $updater = $request->user()->hotel->id ;

        if ($updater !== $hotel->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        $room->update($request->validated());
    
        return new RoomResource($room);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {

        $room = Room::with('hotel')->findOrFail($id);
        $hotel = $room->hotel;
        $deleter = $request->user()->hotel->id;
        
        if ($deleter !== $hotel->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        $room->delete();
     
        return response()->noContent();
    }
}