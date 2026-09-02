<?php

namespace App\Http\Controllers;
use App\Models\Event;

class PublicEventController extends Controller
{
    public function show()
    {
        $event = Event::query()
            ->where('status', 'published')
            ->where('end_date', '>=', now())
            ->orderBy('start_date')
            ->with(['ticketTypes', 'participants'])
            ->first();

        if (! $event) {
            abort(404, 'Aucun événement disponible.');
        }

        return view('events.public', compact('event'));
    }
}