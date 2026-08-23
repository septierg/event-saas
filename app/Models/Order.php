<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\OrderStatus;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'event_id',
        'reference',
        'status',
        'subtotal',
        'total',
        'stripe_checkout_session_id',
        'stripe_payment_intent_id',
    ];

    protected function casts(): array
    {
        return [
            'status' => OrderStatus::class,
            'subtotal' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    
}