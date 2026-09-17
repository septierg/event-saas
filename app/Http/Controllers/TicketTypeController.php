<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\TicketTypeRequest;

class TicketTypeController extends Controller
{
    /**
     * Store a newly created ticket type.
     */
    public function store(TicketTypeRequest $request, Event $event): RedirectResponse
    {
        $validated = $request->validated();
          
        $event->ticketTypes()->create($validated);

        return redirect()
            ->route('events.show', $event)
            ->with('status', 'Ticket type created successfully.');
    }

    /**
     * Update the specified ticket type.
     */
    public function update(
        TicketTypeRequest $request,
        Event $event,
        TicketType $ticketType
    ): RedirectResponse {
        abort_unless($ticketType->event_id === $event->id, 404);

        $validated = $request->validate();

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