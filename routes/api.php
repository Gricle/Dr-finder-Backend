<?php

use App\Http\Controllers\Api\AirportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\FlyController;
use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\Tourist\TouristController;
use App\Http\Controllers\Api\Tourist\ReservationController;
use App\Http\Controllers\Api\Tourist\TicketController;
use App\Http\Controllers\Api\Tourist\VisitController;
use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->group(function () {
    Route::post('/login',[AuthController::class, 'login']);
    Route::post('/logout',[AuthController::class, 'logout'])
    ->middleware(('auth:sanctum'));
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/email/verify', function () {
        return response()->json(['message' => 'Please verify your email address.']);
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return response()->json(['message' => 'Email verified successfully!']);
    })->middleware(['signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return response()->json(['message' => 'Verification link sent!']);
    })->middleware(['throttle:6,1'])->name('verification.send');
});

Route::prefix('doctors')->group(function () {
    Route::get('/', [DoctorController::class, 'index']);
    Route::post('/', [DoctorController::class, 'store']);
    Route::get('/drvisits/{doctorID}', [DoctorController::class, 'getDoctorVisits']);
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
    Route::get('/', [FlyController::class, 'index']);
    Route::post('/', [FlyController::class, 'store'])
    ->middleware('auth:sanctum');
    Route::get('/{fly}', [FlyController::class, 'show']);
    Route::put('/{id}', [FlyController::class, 'update'])
    ->middleware('auth:sanctum');
    Route::delete('/{fly}', [FlyController::class, 'destroy'])
    ->middleware('auth:sanctum');
});

Route::prefix('tourists')->group(function () {
    Route::get('/', [TouristController::class, 'index']);
    Route::post('/', [TouristController::class, 'store']);
    Route::post('/calculateDistance',[TouristController::class,'calculateDistance']);
    Route::get('/touristActivities/{touristID}', [TouristController::class, 'TouristActivities']);
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

Route::prefix('tickets')->group(function () {
    Route::get('/', [TicketController::class, 'index']);
    Route::post('/', [TicketController::class, 'store'])
    ->middleware('auth:sanctum');
    Route::get('/{tiocket}', [TicketController::class, 'show']);
    Route::put('/{id}', [TicketController::class, 'update'])
    ->middleware('auth:sanctum');
    Route::delete('/{tiocket}', [TicketController::class, 'destroy'])
    ->middleware('auth:sanctum');
});

Route::prefix('visits')->group(function () {
    Route::get('/', [VisitController::class, 'index']);
    Route::post('/', [VisitController::class, 'store'])
    ->middleware('auth:sanctum');
    Route::get('/{visit}', [VisitController::class, 'show']);
    Route::delete('/{visit}', [VisitController::class, 'destroy'])
    ->middleware('auth:sanctum');
});