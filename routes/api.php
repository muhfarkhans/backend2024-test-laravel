<?php

use App\Http\Controllers\Api\MyClientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('my-client')->group(function () {
    Route::get('/', [MyClientController::class, 'index']);
    Route::post('/', [MyClientController::class, 'create']);
    Route::post('/{id}', [MyClientController::class, 'update']);
    Route::get('/{slug}', [MyClientController::class, 'test']);
    Route::delete('/{id}', [MyClientController::class, 'delete']);
});