<?php

namespace App\Http\Controllers;

use App\Models\CalendarEvent;
use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CalendarEventController extends Controller
{
    public function index()
    {
        return Inertia::render('Calendar', [
            'events' => CalendarEvent::with('page')->latest()->get(),
            'pages' => Page::with('children')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'date' => 'required|date',
            'page_id' => 'required|exists:pages,id',
            'description' => 'nullable|string',
        ]);

        CalendarEvent::create($validated);
        return back()->with('success', 'Event created successfully');
    }
}
