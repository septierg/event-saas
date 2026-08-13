<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
       public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-6 months', '+6 months');

        return [
            'title' => fake()->randomElement([
                'Montreal Breaking Jam',
                'Montreal Battle',
                'Urban Dance Festival',
                'Breaking Workshop',
                'Summer Dance Jam',
                'Street Dance Battle',
                'Hip Hop Session',
            ]) . ' ' . $startDate->format('Y'),
            'slug' => fake()->unique()->slug(),
            'description' => fake()->paragraphs(2, true),
            'image' => null,
            'location' => fake()->randomElement([
                'Montreal',
                'Montreal, QC',
                'Maison de la culture',
                'Studio de danse',
                'Centre communautaire',
            ]),
            'start_date' => $startDate,
            'end_date' => (clone $startDate)->modify('+1 day'),
            'status' => fake()->randomElement([
                'draft',
                'published',
                'completed',
                'cancelled',
            ]),
        ];
    }

    public function past(): static
    {
        return $this->state(function () {
            $startDate = fake()->dateTimeBetween('-6 months', '-1 day');

            return [
                'start_date' => $startDate,
                'end_date' => (clone $startDate)->modify('+1 day'),
                'status' => 'completed',
            ];
        });
    }

    public function upcoming(): static
    {
        return $this->state(function () {
            $startDate = fake()->dateTimeBetween('+1 day', '+6 months');

            return [
                'start_date' => $startDate,
                'end_date' => (clone $startDate)->modify('+1 day'),
                'status' => 'published',
            ];
        });
    }
}
