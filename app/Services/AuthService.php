<?php

namespace App\Services;

use Lcobucci\JWT\Token;
use App\Models\JwtToken;
use Lcobucci\JWT\Validation\Validator;
use Lcobucci\JWT\Validation\Constraint\RelatedTo;

class AuthService
{
    protected \App\Services\TokenService $tokenService;

    public function __construct(\App\Services\TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
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
}
