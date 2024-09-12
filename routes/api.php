<?php

use App\Http\Controllers\Api\AirportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\Api\RoomController;

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
    Route::post('/', [AirportController::class, 'store'])
    ->middleware('auth:sanctum');
    Route::get('/{aireline}', [AirportController::class, 'show']);
    Route::put('/{id}', [AirportController::class, 'update'])
    ->middleware('auth:sanctum');
    Route::delete('/{airline}', [AirportController::class, 'destroy'])
    ->middleware('auth:sanctum');
});


