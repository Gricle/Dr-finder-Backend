<?php

namespace App\Http\Controllers\Api\Tourist;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['tourist', 'room'])->get();
        return response()->json($reservations);
    }

    public function store(Request $request)
    {
        $tourist = $request->user()->tourist;

        if (!Reservation::isRoomAvailable($request->room_id, $request->check_in, $request->check_out)) {
            return response()->json(['message' => 'Room is not available for the selected dates.'], 400);
        }

        $reservation = Reservation::create([
            'tourist_id' => $tourist->id,
            'room_id' => $request->room_id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'total_price' => Reservation::calculateTotalPrice($request->room_id, $request->check_in, $request->check_out),
        ]);

        return response()->json($reservation, 201);
    }

    public function show($id)
    {
        $reservation = Reservation::with(['tourist', 'room'])->findOrFail($id);
        return response()->json($reservation);
    }

    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $this->authorize('update', $reservation);

        $reservation->update([
            'room_id' => $request->input('room_id', $reservation->room_id),
            'check_in' => $request->input('check_in', $reservation->check_in),
            'check_out' => $request->input('check_out', $reservation->check_out),
            'total_price' => Reservation::calculateTotalPrice($reservation->room_id, 
                $reservation->check_in, 
                $reservation->check_out),
        ]);

        return response()->json($reservation);
    }

    public function destroy($id, Request $request)
    {
        $reserve = Reservation::findOrFail($id);
        $this->authorize('delete', $reserve);

        $reserve->delete();
    
        return response()->noContent();
    }
}