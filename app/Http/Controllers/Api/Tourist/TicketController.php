<?php

namespace App\Http\Controllers\Api\Tourist;

use App\Http\Controllers\Controller;
use App\Models\Fly;
use App\Models\Ticket;
use App\Http\Requests\Ticket\StoreTicketRequest;
use App\Http\Requests\Ticket\UpdateTicketRequest;
use App\Http\Resources\TicketResource;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::all();
        return TicketResource::collection($tickets);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        $tourist = $request->user()->tourist;
        
        if (Ticket::isFlyFull($request->fly_id)) {
            return response()->json(['message' => 'The flight is full. You cannot buy a ticket.'], 400);
        }
    
        $seatNumber = $this->addTakenSeatToFly($request->fly_id);

        $ticket = Ticket::create([
            'tourist_id' => $tourist->id,
            'fly_id' => $request->fly_id,
            'seat_number' =>$seatNumber,
        ]);
        return response()->json([
            'message' => 'Ticket created successfully!',
            'ticket' => new TicketResource($ticket)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }

    public function addTakenSeatToFly($flyID)
    {
        $fly = Fly::findOrFail($flyID);
        if ($fly->taken_seats < $fly->seats) {
    
            $fly->taken_seats += 1;
            $fly->save();
        }
        return $fly->taken_seats;
    }
}
