<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PersonController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::resource('people', PersonController::class);
        Route::post('people/import', [PersonController::class, 'import']);
    });
    Route::post('/auth', [AuthController::class, 'auth']);
});
