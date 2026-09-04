<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Order;
use App\Models\Participant;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEvents = Event::count();

        $totalRevenue = Order::where('status', 'paid')->sum('total');

        $totalOrders = Order::count();

        $totalParticipants = Participant::count();

        return view('dashboard', compact(
            'totalEvents',
            'totalRevenue',
            'totalOrders',
            'totalParticipants'
        ));
    }
}