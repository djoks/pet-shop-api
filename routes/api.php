<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
        Route::middleware(['admin.check'])->prefix('admin')->group(function (): void {
            Route::get('logout', [AuthController::class, 'logout']);
        });

        // User
        Route::prefix('user')->group(function (): void {
            Route::get('logout', [AuthController::class, 'logout']);
        });
    });
});
