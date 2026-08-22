<?php

use App\Helpers\ApiResponse;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->get('/user', function (Request $request){
    return ApiResponse::success(
        $request->user(),
        'Authenticated user.'
    );
});

Route::get('/test', function () {
    return ApiResponse::success(
        ['status' => 'working'],
        'Hitek API is working successfully.'
    );
});

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
});