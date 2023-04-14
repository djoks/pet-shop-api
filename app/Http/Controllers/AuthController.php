<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;

class AuthController extends Controller
{
    public function login(
        LoginRequest $request,
        AuthService $authService
    ): JsonResponse {
        $response = $authService->login(
            email: $request->email,
            password: $request->password
        );

        if ($response->code === 200) {
            return response()->json([
                'message' => 'Login successful.',
                'data' => new LoginResource($response->data),
            ], 200);
        }

        return response()->json(
            [
                'message' => $response->message,
            ],
            $response->code
        );
    }

    public function logout(Request $request, AuthService $authService)
    {
        $response = $authService->logout($request->bearerToken());

        return response()->json(['message' => $response->message], $response->code);
    }
}
