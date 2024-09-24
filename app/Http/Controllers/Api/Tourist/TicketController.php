<?php

namespace App\Http\Controllers\Api\Tourist;

use App\Http\Controllers\Controller;
use App\Models\Fly;
use App\Models\Ticket;
use App\Http\Requests\Ticket\StoreTicketRequest;
use App\Http\Requests\Ticket\UpdateTicketRequest;
use App\Http\Resources\TicketResource;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::all();
        return TicketResource::collection($tickets);
    }

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
            'seat_number' => $seatNumber,
        ]);

        return response()->json([
            'message' => 'Ticket created successfully!',
            'ticket' => new TicketResource($ticket)
        ], 201);
    }

    public function show(Ticket $ticket)
    {
        return new TicketResource($ticket);
    }

    public function destroy($id, Request $request)
    {
        $ticket = Ticket::findOrFail($id);
        $tourist = $ticket->tourist;

        if ($request->user()->tourist->id !== $tourist->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $ticket->delete();
    
        return response()->noContent();
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