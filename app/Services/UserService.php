<?php

namespace App\Services;

use App\Models\User;
use Lcobucci\JWT\Token;
use App\Models\JwtToken;
use Lcobucci\JWT\Validation\Validator;
use Lcobucci\JWT\Validation\Constraint\RelatedTo;

class UserService
{
    protected \App\Services\TokenService $tokenService;

    public function __construct(\App\Services\TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * @return App\Models\User
     */
    public function getByUuid(string $uuid)
    {
        $user = User::where('uuid', $uuid)->first();
        if (!$user) {
            return (object) [
                'code' => 404,
                'message' => 'User not found.',
            ];
        }

        return $user;
    }

    /**
     * @return boolean
     */
    public function isAdmin(string $uuid)
    {
        $user = $this->getByUuid($uuid);
        return $user->is_admin;
    }

    /**
     * @return array<App\Models\User>
     */
    public function getAll()
    {
        return User::all();
    }
}
