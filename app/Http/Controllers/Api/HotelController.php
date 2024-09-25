<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HotelResource;
use App\Models\Hotel;
use App\Http\Requests\Hotel\StoreHotelRequest;
use App\Http\Requests\Hotel\UpdateHotelRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::all();
        return HotelResource::collection($hotels);
    }

    public function store(StoreHotelRequest $request)
    {
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        $user->hotel()->create([
            'name' => $request->name,
            'stars' => $request->stars,
            'description' => $request->description,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'address' => $request->address,
        ]);
        
        $user->sendEmailVerificationNotification();

        return response()->json([
            'status' => true,
            'message' => 'User registered successfully! Please check your email for verification.',
            'token' => $user->createToken("API TOKEN")->plainTextToken,
        ], 201);
    }

    public function show(Hotel $hotel)
    {
        return new HotelResource($hotel);
    }

    public function update(UpdateHotelRequest $request, Hotel $hotel)
    {
        $this->authorize('update', $hotel);
        
        $hotel->update($request->validated());
        
        return new HotelResource($hotel);
    }

    public function destroy(Hotel $hotel, Request $request)
    {
        $this->authorize('delete', $hotel);
        
        $hotel->delete();
        
        return response()->noContent();
    }
    
    public function recommendHotel(Request $request)
    {
        $query = DB::table('hotels')
            ->leftJoin('ratings', function ($join) {
                $join->on('ratings.rateable_id', '=', 'hotels.id')
                     ->where('ratings.rateable_type', '=', 'App\\Models\\Hotel');
            })
            ->select('hotels.id', 'hotels.name', 
                     DB::raw('AVG(ratings.score) as average_score'), 
                     DB::raw('COUNT(ratings.id) as ratings_count'))
            ->groupBy('hotels.id', 'hotels.name')
            ->having('ratings_count', '>', 0);

        $sortBy = $request->input('sort_by', 'average_score'); 
        $order = $request->input('order', 'desc');

        if ($sortBy === 'average_score') {
            $query->orderBy('average_score', $order);
        } elseif ($sortBy === 'ratings_count') {
            $query->orderBy('ratings_count', $order);
        } elseif ($sortBy === 'combined') {
            $query->orderBy(DB::raw('AVG(ratings.score) * COUNT(ratings.id)'), $order);
        }
    
        return response()->json($query->get());
    }
}