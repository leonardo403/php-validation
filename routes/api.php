<?php

use App\Http\Controllers\Api\ClientController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('clients', ClientController::class);
    Route::delete('clients/bulk-delete', [ClientController::class, 'bulkDelete']);
    Route::patch('clients/{id}/toggle-status', [ClientController::class, 'toggleStatus']);
});

Route::post('clients/register', [ClientController::class, 'store']);
