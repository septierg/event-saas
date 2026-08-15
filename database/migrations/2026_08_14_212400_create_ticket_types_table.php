<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ticket_types', function (Blueprint $table) {
            $table->id();

            // Event associated with this ticket type
            $table->foreignId('event_id')
                ->constrained()
                ->cascadeOnDelete();

            // Ticket information
            $table->string('name');
            $table->text('description')->nullable();

            // Pricing
            $table->decimal('price', 10, 2);

            // Number of tickets available
            $table->unsignedInteger('quantity');

            // Ticket sales period
            $table->dateTime('sales_start')->nullable();
            $table->dateTime('sales_end')->nullable();

            // Ticket type status
            $table->string('status')->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_types');
    }
};