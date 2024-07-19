<?php

use App\Http\Controllers\AmbulanceController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', function (Request $request){
    return response()->json(['message' => 'Hello World!']);
});

Route::group(['prefix'=>'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::get('users', [AuthController::class, 'getUsers']);
    Route::delete('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('refresh', [AuthController::class, 'refresh'])->middleware('auth:sanctum');
    Route::get('user', [AuthController::class, 'user'])->middleware('auth:sanctum');
});

Route::get('/superadmins', [AuthController::class, 'getSuperAdmins'])->middleware('auth:sanctum');
Route::get('/doctors', [AuthController::class, 'getDoctors'])->middleware('auth:sanctum');
Route::get('/patients', [AuthController::class, 'getPatients'])->middleware('auth:sanctum');

Route::fallback(function () {
    return response()->json(['message' => 'Resource Not Found'], 404);
});

Route::group(['prefix' => 'ambulances'], function () {
    Route::get('/', [AmbulanceController::class, 'index'])->middleware('auth:sanctum');
    Route::post('/', [AmbulanceController::class, 'store']);
    Route::get('/{ambulance}', [AmbulanceController::class, 'show'])->middleware('auth:sanctum');
    Route::put('/{ambulance}', [AmbulanceController::class, 'update'])->middleware('auth:sanctum');
    Route::delete('/{ambulance}', [AmbulanceController::class, 'destroy'])->middleware('auth:sanctum');
});

// Route::group(['prefix' => 'appointments'], Appo);
Route::apiResource('appointments', AppointmentController::class);