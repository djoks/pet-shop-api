<?php

namespace App\Services;

use Lcobucci\JWT\Token;
use App\Models\JwtToken;
use Illuminate\Http\Request;
use Lcobucci\JWT\Validation\Validator;
use Lcobucci\JWT\Validation\Constraint\RelatedTo;

class AuthService
{
    protected \App\Services\TokenService $tokenService;
    protected \App\Services\UserService $userService;

    public function __construct(
        \App\Services\TokenService $tokenService,
        \App\Services\UserService $userService
    ) {
        $this->tokenService = $tokenService;
        $this->userService = $userService;
    }

    /**
     * @return object{code: int, message: string, data: App\Models\User|array<string, string>|null}
     */
    public function login(
        string $email,
        string $password
    ): object {
        if (auth()->attempt(['email' => $email, 'password' => $password])) {
            $user = auth()->user();
            $user['token'] = $this->tokenService->generate(user: $user);
            $message = 'Login successful.';
            $code = 200;
        } else {
            $user = null;
            $message = 'Login failed, invalid credentials.';
            $code = 403;
        }

        return (object) [
            'code' => $code,
            'message' => $message,
            'data' => $user,
        ];
    }

    public function loginAdministrator(
        string $email,
        string $password
    ): object {
        if (
            auth()->attempt([
                'email' => $email,
                'password' => $password,
                'is_admin' => true
            ])
        ) {
            $user = auth()->user();
            $user['token'] = $this->tokenService->generate(user: $user);
            $message = 'Login successful.';
            $code = 200;
        } else {
            $user = null;
            $message = 'Login failed, invalid credentials.';
            $code = 403;
        }

        return (object) [
            'code' => $code,
            'message' => $message,
            'data' => $user,
        ];
    }

    public function verify(Token $token): object
    {
        $validator = new Validator();

        if (!$validator->validate($token, new RelatedTo($token->claims()->get('sub')))) {
            return (object) [
                'code' => 401,
                'message' => 'Bearer token has expired.',
            ];
        }

        $jwtToken = JwtToken::where('unique_id', $token->claims()->get('jti'))->first();

        if (!$jwtToken) {
            return (object) [
                'code' => 401,
                'message' => 'Invalid bearer token.',
            ];
        }

        if ($jwtToken->expires_at < now()) {
            return (object) [
                'code' => 401,
                'message' => 'Bearer token has expired.',
            ];
        }

        return (object) [
            'code' => 200,
            'message' => 'Bearer token is valid.',
        ];
    }

    public function logout(string $bearerToken): object
    {
        $token = $this->tokenService->decode($bearerToken);

        if (!$token) {
            return (object) ['code' => 400, 'message' => 'Invalid bearer token.'];
        }

        // Find the token in the database and delete it.
        $jwtToken = JwtToken::where('unique_id', $token->claims()->get('jti'))->first();
        $jwtToken->delete();

        // Log the user out.
        auth()->logout();

        return (object) ['code' => 200, 'message' => 'Successfully logged out.'];
    }
}
