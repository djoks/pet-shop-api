<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_uuid',
        'order_status_uuid',
        'payment_uuid',
        'uuid',
        'products',
        'address',
        'delivery_fee',
        'amount',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'products' => 'json',
        'address' => 'json',
    ];

    /**
     * @return BelongsTo<User, Order>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }

    /**
     * @return BelongsTo<OrderStatus, Order>
     */
    public function orderStatus(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_uuid', 'uuid');
    }

    /**
     * @return BelongsTo<Payment, Order>
     */
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class, 'payment_uuid', 'uuid');
    }
}
