<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $upcoming = Event::where('status', 'upcoming')->orderBy('start_at')->get();
        $past     = Event::where('status', 'finished')->orderByDesc('start_at')->take(10)->get();
        return view('event.index', compact('upcoming', 'past'));
    }

    public function show(string $slug)
    {
        $event = Event::where('slug', $slug)
            ->whereIn('status', ['upcoming', 'finished'])
            ->firstOrFail();

        return view('event.show', compact('event'));
    }

    public function calendar()
    {
        $events = Event::orderBy('start_at')->get();
        return view('kalender.index', compact('events'));
    }
}
