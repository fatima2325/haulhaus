<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'name',
        'email',
        'address',
        'payment_method',
        'total_amount',
        'total_quantity',
        'status',
        'items',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'items' => 'array',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order items (now stored in items JSON column).
     * This method is kept for backward compatibility but returns the items array.
     */
    public function getOrderItemsAttribute()
    {
        return $this->items ?? [];
    }
}

