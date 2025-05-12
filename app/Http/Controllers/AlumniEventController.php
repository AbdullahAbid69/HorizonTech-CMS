<?php

namespace App\Http\Controllers;

use App\Models\AlumniEvent;
use Illuminate\Http\Request;

class AlumniEventController extends Controller
{
    // Show all active (non-deleted) events
    public function index()
    {
        $events = AlumniEvent::all(); // Only shows non-soft-deleted by default
        return view('Admin.alumni_events.alumni_events', compact('events'));
    }
    public function AlumniIndex()
    {
        $events = AlumniEvent::all(); // Only shows non-soft-deleted by default
        return view('alumini.events.events', compact('events'));
    }

    // Show trashed (soft-deleted) events
    public function trashed()
    {
        $events = AlumniEvent::onlyTrashed()->get();
        return view('Admin.alumni_events.trashed', compact('events'));
    }

    // Show form to create a new event
    public function create()
    {
        return view('Admin.alumni_events.addalumni_events');
    }

    // Store a new event
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'venue' => 'nullable|string|max:255',
            'organizer_name' => 'nullable|string|max:255',
            'event_date' => 'required|date',
            'event_time' => 'required',
            'fee' => 'required|numeric|min:0',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string|max:20',
            'status' => 'required|in:upcoming,completed,cancelled',
        ]);

        AlumniEvent::create($request->all());

        return redirect()->route('admin.alumni_events.index')->with('success', 'Event created successfully!');
    }

    // Show form to edit an existing event
    public function edit($id)
    {
        $event = AlumniEvent::findOrFail($id);
        return view('Admin.alumni_events.editAlumni_events', compact('event'));
    }

    // Update an existing event
    public function update(Request $request, $id)
    {
        $event = AlumniEvent::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'venue' => 'nullable|string|max:255',
            'organizer_name' => 'nullable|string|max:255',
            'event_date' => 'required|date',
            'event_time' => 'required',
            'fee' => 'required|numeric|min:0',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string|max:20',
            'status' => 'required|in:upcoming,completed,cancelled',
        ]);

        $event->update($request->all());

        return redirect()->route('admin.alumni_events.index')->with('success', 'Event updated successfully!');
    }

    // Soft delete
    public function destroy($id)
    {
        $event = AlumniEvent::findOrFail($id);
        $event->delete();

        return redirect()->route('admin.alumni_events.index')->with('success', 'Event soft-deleted successfully!');
    }

    // Restore a soft-deleted event
    public function restore($id)
    {
        $event = AlumniEvent::onlyTrashed()->findOrFail($id);
        $event->restore();

        return redirect()->route('admin.alumni_events.index')->with('success', 'Event restored successfully!');
    }

    // Permanently delete (force delete)
    public function forceDelete($id)
    {
        $event = AlumniEvent::onlyTrashed()->findOrFail($id);
        $event->forceDelete();

        return redirect()->route('admin.alumni_events.trashed')->with('success', 'Event permanently deleted!');
    }
}