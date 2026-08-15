<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $events = Event::factory()
            ->count(20)
            ->create();

        $events->each(function (Event $event) {
            $event->ticketTypes()->createMany([
                [
                    'name' => 'Early Bird',
                    'description' => 'Limited early bird tickets.',
                    'price' => 15.00,
                    'quantity' => 50,
                    'sales_start' => now(),
                    'sales_end' => $event->start_date,
                    'status' => 'active',
                ],
                [
                    'name' => 'Regular',
                    'description' => 'Standard event admission.',
                    'price' => 25.00,
                    'quantity' => 150,
                    'sales_start' => now(),
                    'sales_end' => $event->start_date,
                    'status' => 'active',
                ],
            ]);
        });

        Event::factory()
            ->past()
            ->count(10)
            ->create()
            ->each(function (Event $event) {
                $event->ticketTypes()->create([
                    'name' => 'Regular',
                    'description' => 'Standard event admission.',
                    'price' => 20.00,
                    'quantity' => 100,
                    'sales_start' => $event->start_date->copy()->subMonths(2),
                    'sales_end' => $event->start_date,
                    'status' => 'inactive',
                ]);
            });

        Event::factory()
            ->upcoming()
            ->count(10)
            ->create()
            ->each(function (Event $event) {
                $event->ticketTypes()->createMany([
                    [
                        'name' => 'Early Bird',
                        'description' => 'Limited early bird tickets.',
                        'price' => 15.00,
                        'quantity' => 50,
                        'sales_start' => now(),
                        'sales_end' => $event->start_date,
                        'status' => 'active',
                    ],
                    [
                        'name' => 'Regular',
                        'description' => 'Standard event admission.',
                        'price' => 25.00,
                        'quantity' => 150,
                        'sales_start' => now(),
                        'sales_end' => $event->start_date,
                        'status' => 'active',
                    ],
                ]);
            });
    }
}