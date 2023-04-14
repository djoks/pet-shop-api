<?php

namespace App\Services;

use App\Models\User;
use Lcobucci\JWT\Token;
use App\Models\JwtToken;
use Illuminate\Support\Str;
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
     * @return App\Models\User|null
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
    public function getAll($page = 1, $limit = 10, $sortBy = 'id', $desc = false)
    {
        $query = User::query();
        $query->orderBy($sortBy, $desc ? 'desc' : 'asc');
        $total = $query->count();
        $query->skip(($page - 1) * $limit)->take($limit);
        $users = $query->get();

        $response = [
            'data' => $users,
            'page' => (int) $page,
            'limit' => (int) $limit,
            'total' => $total,
            'sort_by' => $sortBy,
            'desc' => (bool) $desc,
        ];

        return $response;
    }

    public function create(array $params)
    {
        return User::create([
            'first_name' => $params['first_name'],
            'last_name' => $params['last_name'],
            'uuid' => Str::uuid(),
            'email' => $params['email'],
            'password' => $params['password'],
            'is_admin' => $params['is_admin'],
            'avatar' => $params['avatar'] ?? '',
            'address' => $params['address'],
            'phone_number' => $params['phone_number'],
            'is_marketing' => $params['is_marketing'],
        ]);
    }
}
