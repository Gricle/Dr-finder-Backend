<?php

use App\Http\Controllers\Api\AirportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\Tourist\TouristController;
use App\Http\Controllers\Api\Tourist\ReservationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('doctors')->group(function () {
    Route::get('/', [DoctorController::class, 'index']);
    Route::post('/', [DoctorController::class, 'store']);
    Route::get('/{doctor}', [DoctorController::class, 'show']);
    Route::put('/{id}', [DoctorController::class, 'update'])
     ->middleware('auth:sanctum');
    Route::delete('/{doctor}', [DoctorController::class, 'destroy'])
    ->middleware('auth:sanctum');
});

Route::prefix('hotels')->group(function () {
    Route::get('/recommend', [HotelController::class, 'recommendHotel']);
    Route::get('/', [HotelController::class, 'index']);
    Route::post('/', [HotelController::class, 'store']);
    Route::get('/{hotel}', [HotelController::class, 'show']);
    Route::put('/{id}', [HotelController::class, 'update'])
    ->middleware('auth:sanctum');
    Route::delete('/{hotel}', [HotelController::class, 'destroy'])
    ->middleware('auth:sanctum');
});

Route::prefix('rooms')->group(function () {
    Route::get('/', [RoomController::class, 'index']);
    Route::post('/', [RoomController::class, 'store'])
    ->middleware('auth:sanctum');
    Route::get('/{room}', [RoomController::class, 'show']);
    Route::put('/{id}', [RoomController::class, 'update'])
    ->middleware('auth:sanctum');
    Route::delete('/{room}', [RoomController::class, 'destroy'])
    ->middleware('auth:sanctum');
});

Route::prefix('airports')->group(function () {
    Route::get('/', [AirportController::class, 'index']);
    Route::post('/', [AirportController::class, 'store']);
    Route::get('/{airport}', [AirportController::class, 'show']);
    Route::put('/{id}', [AirportController::class, 'update'])
    ->middleware('auth:sanctum');
    Route::delete('/{airport}', [AirportController::class, 'destroy'])
    ->middleware('auth:sanctum');
});

Route::prefix('flies')->group(function () {
    Route::get('/', [AirportController::class, 'index']);
    Route::post('/', [AirportController::class, 'store'])
    ->middleware('auth:sanctum');
    Route::get('/{fly}', [AirportController::class, 'show']);
    Route::put('/{id}', [AirportController::class, 'update'])
    ->middleware('auth:sanctum');
    Route::delete('/{fly}', [AirportController::class, 'destroy'])
    ->middleware('auth:sanctum');
});

Route::prefix('tourists')->group(function () {
    Route::get('/', [TouristController::class, 'index']);
    Route::post('/', [TouristController::class, 'store']);
    Route::get('/{tourist}', [TouristController::class, 'show']);
    Route::put('/{id}', [TouristController::class, 'update'])
    ->middleware('auth:sanctum');
    Route::delete('/{tourist}', [TouristController::class, 'destroy'])
    ->middleware('auth:sanctum');
});

Route::prefix('ratings')->group(function () {
    Route::get('/', [RatingController::class, 'index']);
    Route::post('/', [RatingController::class, 'store'])
    ->middleware('auth:sanctum');
    Route::get('/{rating}', [RatingController::class, 'show']);
    Route::put('/{id}', [RatingController::class, 'update'])
    ->middleware('auth:sanctum');
    Route::delete('/{rating}', [RatingController::class, 'destroy'])
    ->middleware('auth:sanctum');
});

Route::prefix('reserves')->group(function () {
    Route::get('/', [ReservationController::class, 'index']);
    Route::post('/', [ReservationController::class, 'store'])
    ->middleware('auth:sanctum');
    Route::get('/{reserve}', [ReservationController::class, 'show']);
    Route::put('/{id}', [ReservationController::class, 'update'])
    ->middleware('auth:sanctum');
    Route::delete('/{reserve}', [ReservationController::class, 'destroy'])
    ->middleware('auth:sanctum');
});