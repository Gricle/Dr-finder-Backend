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
        $this->authorize('create', Room::class);

        $hotel = $request->user()->hotel;
        $room = $hotel->rooms()->create($request->validated());

        return response()->json([
            'message' => 'Room created successfully!',
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
    public function update(UpdateRoomRequest $request, Room $room)
    {
        $this->authorize('update', $room);

        $room->update($request->validated());

        return new RoomResource($room);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room, Request $request)
    {
        $this->authorize('delete', $room);

        $room->delete();

        return response()->noContent();
    }
}