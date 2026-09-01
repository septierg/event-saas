<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'alias' => ['required', 'string', 'max:100'],
        ]);

        $event->participants()->create($validated);

        return back()->with(
            'registration_success',
            'Votre inscription a bien été enregistrée.'
        );
    }
}