<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_status_id',
        'payment_id',
        'uuid',
        'products',
        'address',
        'delivery_fee',
        'amount',
    ];

    protected $casts = [
        'products' => 'json',
        'address' => 'json'
    ];
    
    /**
     * @return BelongsTo<User, Order>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<OrderStatus, Order>
     */
    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    /**
     * @return BelongsTo<Payment, Order>
     */
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
