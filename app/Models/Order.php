<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'order_number',
        'amount',
        'status',
        'order_date',
    ];

    protected $casts = [
        'order_date' => 'date',
        'amount' => 'decimal:2',
    ];

    /**
     * Get the customer that owns the order.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Generate a unique order number.
     */
    public static function generateOrderNumber(): string
    {
        $prefix = 'ORD-';
        $date = now()->format('Ymd');
        $random = strtoupper(substr(uniqid(), -4));
        return $prefix . $date . '-' . $random;
    }
}
