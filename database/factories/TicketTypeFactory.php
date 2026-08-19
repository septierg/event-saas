<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TicketType>
 */
class TicketTypeFactory extends Factory
{
    protected $model = TicketType::class;

    public function definition(): array
    {
        $salesStart = now();
        $salesEnd = $salesStart->copy()->addMonths(2);

        return [
            'event_id' => Event::factory(),

            'name' => fake()->randomElement([
                'Early Bird',
                'Regular',
                'VIP',
                'Workshop',
                'Spectator',
            ]),

            'description' => fake()->optional()->sentence(),

            'price' => fake()->randomFloat(2, 10, 100),

            'quantity' => fake()->numberBetween(30, 300),

            'sales_start' => $salesStart,

            'sales_end' => $salesEnd,

            'status' => 'active',
        ];
    }
}