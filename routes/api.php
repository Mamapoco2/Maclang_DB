<?php

use App\Http\Controllers\Api\UserApprovalController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware(['auth:sanctum', 'permission:user.approve'])
    ->prefix('users')
    ->group(function () {

        Route::get('/pending', [UserApprovalController::class, 'pending']);
        Route::patch('/{id}/approve', [UserApprovalController::class, 'approve']);
        Route::patch('/{id}/reject', [UserApprovalController::class, 'reject']);

    });
