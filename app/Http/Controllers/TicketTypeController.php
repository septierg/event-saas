<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TicketTypeController extends Controller
{
    /**
     * Store a newly created ticket type.
     */
    public function store(Request $request, Event $event): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'price' => [
                'required',
                'numeric',
                'min:0',
            ],
            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],
            'sales_start' => [
                'nullable',
                'date',
            ],
            'sales_end' => [
                'nullable',
                'date',
                'after_or_equal:sales_start',
            ],
            'status' => [
                'required',
                Rule::in(['active', 'inactive']),
            ],
        ]);

        $event->ticketTypes()->create($validated);

        return redirect()
            ->route('events.show', $event)
            ->with('status', 'Ticket type created successfully.');
    }

    /**
     * Update the specified ticket type.
     */
    public function update(
        Request $request,
        Event $event,
        TicketType $ticketType
    ): RedirectResponse {
        abort_unless($ticketType->event_id === $event->id, 404);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'price' => [
                'required',
                'numeric',
                'min:0',
            ],
            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],
            'sales_start' => [
                'nullable',
                'date',
            ],
            'sales_end' => [
                'nullable',
                'date',
                'after_or_equal:sales_start',
            ],
            'status' => [
                'required',
                Rule::in(['active', 'inactive']),
            ],
        ]);

        $ticketType->update($validated);

        return redirect()
            ->route('events.show', $event)
            ->with('status', 'Ticket type updated successfully.');
    }

    /**
     * Remove the specified ticket type.
     */
    public function destroy(
        Event $event,
        TicketType $ticketType
    ): RedirectResponse {
        abort_unless($ticketType->event_id === $event->id, 404);

        $ticketType->delete();

        return redirect()
            ->route('events.show', $event)
            ->with('status', 'Ticket type deleted successfully.');
    }
}