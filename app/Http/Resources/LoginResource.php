<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    protected string $token;
    protected string $first_name;
    protected string $last_name;
    protected string $phone_number;
    protected string $email;
    protected string $address;
    protected bool $is_marketing;
    protected string $avatar;

    public function __construct(object $resource)
    {
        parent::__construct($resource);
        $this->token = $resource->token;
        $this->first_name = $resource->first_name;
        $this->last_name = $resource->last_name;
        $this->phone_number = $resource->phone_number;
        $this->email = $resource->email;
        $this->address = $resource->address;
        $this->is_marketing = $resource->is_marketing;
        $this->avatar = $resource->avatar ?? '';
    }

    /**
     * Transform the resource into an array.
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     *
     * @return array<string, string|int|bool>
     */
    public function toArray(Request $request): array
    {
        return [
            'token' => $this->token,
            'name' => $this->first_name . ' ' . $this->last_name,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'address' => $this->address,
            'marketing_preferences' => $this->is_marketing ? 'Yes' : 'No',
            'avatar' => $this->avatar,
        ];
    }
}
