<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderStatusController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function (): void {
    // Un-Protected Admin Routes
    Route::prefix('admin')->group(function (): void {
        Route::post('login', [AuthController::class, 'loginAdministrator']);
    });

    // Un-Protected User Routes
    Route::prefix('user')->group(function (): void {
        Route::post('login', [AuthController::class, 'login']);
    });

    // Protected Routes
    Route::middleware(['auth.check'])->group(function (): void {
        // Admin
        Route::middleware(['admin.check'])->group(function (): void {
            Route::prefix('admin')->group(function (): void {
                Route::get('logout', [AuthController::class, 'logout']);
                Route::post('create', [UserController::class, 'store']);
                Route::get('user-listing', [UserController::class, 'index']);
            });

            Route::get('order-statuses', [OrderStatusController::class, 'index']);
            Route::get('orders', [OrderController::class, 'index']);
            Route::patch('order/{uuid}', [OrderController::class, 'update']);
        });

        // User
        Route::prefix('user')->group(function (): void {
            Route::get('logout', [AuthController::class, 'logout']);
        });
    });

    Route::get('products', [ProductController::class, 'index']);
});
