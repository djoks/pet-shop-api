<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\TokenService;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    protected TokenService $tokenService;
    protected UserService $userService;

    public function __construct(TokenService $tokenService, UserService $userService)
    {
        $this->tokenService = $tokenService;
        $this->userService = $userService;
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
        $uuid = $token->claims()->get('user_uuid');

        if (!$this->userService->isAdmin($uuid)) {
            return response()->json(['message' => 'You are not an admin.'], 403);
        }

        return $next($request);
    }
}
