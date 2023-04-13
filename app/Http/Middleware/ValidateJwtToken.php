<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Services\TokenService;
use Symfony\Component\HttpFoundation\Response;

class ValidateJwtToken
{
    protected TokenService $tokenService;
    protected AuthService $authService;


    public function __construct(TokenService $tokenService, AuthService $authService)
    {
        $this->tokenService = $tokenService;
        $this->authService = $authService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $bearerToken = $request->bearerToken();

        if (!$bearerToken) {
            return response()->json(['message' => 'Missing bearer token.'], 401);
        }

        $token = $this->tokenService->decode($bearerToken);
        $response = $this->authService->verify($token);

        if ($response->code !== 200) {
            return response()->json(['message' => $response->message], $response->code);
        }

        return $next($request);
    }
}
