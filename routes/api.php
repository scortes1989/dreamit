<?php

use App\Http\Controllers\Api\AccessController;
use App\Http\Controllers\Api\BuildingAccessController;
use App\Http\Controllers\Api\BuildingController;
use App\Http\Controllers\Api\LockController;
use App\Http\Controllers\Api\UserAccessController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])->group(function ($route) {
    $route->get('buildings/{building}/accesses', [BuildingAccessController::class, 'index']);
    $route->get('users/{user}/accesses', [UserAccessController::class, 'index']);

    $route->post('accesses', [AccessController::class, 'store']);

    $route->get('locks', [LockController::class, 'index']);
    $route->post('locks', [LockController::class, 'store']);
    $route->delete('locks/{lock}', [LockController::class, 'destroy']);

    $route->apiResource('users', UserController::class);
    $route->apiResource('buildings', BuildingController::class);
});
