<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'customer' => $this->user->first_name . ' ' . $this->user->last_name,
            'status' => $this->orderStatus->title,
            'products' => collect(json_decode($this->products))->sum('quantity'),
            'amount' => $this->amount,
            'delivery_fee' => $this->delivery_fee,
        ];
    }
}
