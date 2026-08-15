<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketType extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'description',
        'price',
        'quantity',
        'sales_start',
        'sales_end',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'quantity' => 'integer',
            'sales_start' => 'datetime',
            'sales_end' => 'datetime',
        ];
    }

    /**
     * The event this ticket type belongs to.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }


    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}