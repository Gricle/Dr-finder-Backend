<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DoctorController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('doctors')->group(function () {
    Route::get('/', [DoctorController::class, 'index']);
    Route::post('/', [DoctorController::class, 'store']);
    Route::get('/{doctor}', [DoctorController::class, 'show']);
    Route::put('/{id}', [DoctorController::class, 'update'])->middleware('auth:sanctum');
    Route::delete('/{doctor}', [DoctorController::class, 'destroy'])->middleware('auth:sanctum');
});