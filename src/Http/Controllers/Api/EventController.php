<?php

namespace BamboleeDigital\EventUserManager\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use BamboleeDigital\EventUserManager\Http\Resources\EventResource;
use BamboleeDigital\EventUserManager\Http\Resources\EventNoteResource;
use BamboleeDigital\EventUserManager\Models\Event;
use BamboleeDigital\EventUserManager\Models\EventNote;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    protected $eventModel;
    protected $eventNoteModel;

    public function __construct()
    {
        $this->eventModel = app(config('event-user-manager.models.event'));
        $this->eventNoteModel = app(config('event-user-manager.models.event_note'));
    }

    public function index(Request $request)
    {
        $events = $request->user()->events()
            ->when($request->filled('status'), function ($query) use ($request) {
                return $query->where('status', $request->status);
            })
            ->paginate(config('event-user-manager.pagination.per_page', 15));

        return EventResource::collection($events);
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateEvent($request);
        $event = $request->user()->events()->create($validatedData);
        
        $this->handleAttachments($request, $event, 'attachments');
        $this->handleAttachments($request, $event, 'images');
        $this->handleMetadata($request, $event);

        return new EventResource($event);
    }

    public function show(Request $request, $id)
    {
        $event = $this->eventModel->findOrFail($id);
        $this->authorize('view', $event);
        return new EventResource($event);
    }

    public function update(Request $request, $id)
    {
        $event = $this->eventModel->findOrFail($id);
        $this->authorize('update', $event);

        $validatedData = $this->validateEvent($request);
        $event->update($validatedData);

        $this->handleAttachments($request, $event, 'attachments');
        $this->handleAttachments($request, $event, 'images');
        $this->handleMetadata($request, $event);

        return new EventResource($event);
    }

    public function destroy(Request $request, $id)
    {
        $event = $this->eventModel->findOrFail($id);
        $this->authorize('delete', $event);
        $event->delete();
        return response()->json(null, 204);
    }

    public function pastEvents(Request $request)
    {
        $events = $request->user()->events()
            ->where('end_date', '<', Carbon::now())
            ->paginate(config('event-user-manager.pagination.per_page', 15));

        return EventResource::collection($events);
    }

    public function futureEvents(Request $request)
    {
        $events = $request->user()->events()
            ->where('start_date', '>', Carbon::now())
            ->paginate(config('event-user-manager.pagination.per_page', 15));

        return EventResource::collection($events);
    }

    public function eventsByStatus(Request $request, $status)
    {
        $events = $request->user()->events()
            ->where('status', $status)
            ->paginate(config('event-user-manager.pagination.per_page', 15));

        return EventResource::collection($events);
    }

    // Event Notes CRUD
    public function storeNote(Request $request, $eventId)
    {
        $event = $this->eventModel->findOrFail($eventId);
        $this->authorize('update', $event);

        $validatedData = $request->validate([
            'content' => 'required|string',
        ]);

        $note = $event->notes()->create($validatedData);

        $this->handleAttachments($request, $note, 'attachments');
        $this->handleAttachments($request, $note, 'images');

        return new EventNoteResource($note);
    }

    public function updateNote(Request $request, $eventId, $noteId)
    {
        $event = $this->eventModel->findOrFail($eventId);
        $this->authorize('update', $event);

        $note = $event->notes()->findOrFail($noteId);

        $validatedData = $request->validate([
            'content' => 'required|string',
        ]);

        $note->update($validatedData);

        $this->handleAttachments($request, $note, 'attachments');
        $this->handleAttachments($request, $note, 'images');

        return new EventNoteResource($note);
    }

    public function destroyNote(Request $request, $eventId, $noteId)
    {
        $event = $this->eventModel->findOrFail($eventId);
        $this->authorize('update', $event);

        $note = $event->notes()->findOrFail($noteId);
        $note->delete();

        return response()->json(null, 204);
    }

    
    protected function validateEvent(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'event_type_id' => 'required|exists:'.config('event-user-manager.tables.event_types').',id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'duration_minutes' => 'nullable|integer|min:1',
            'status' => 'required|in:draft,active,past,cancelled,pending,rescheduled',
            'recurrence_pattern_id' => 'nullable|exists:'.config('event-user-manager.tables.recurrence_patterns').',id',
            'frequency_count' => 'nullable|integer|min:1',
            'frequency_type' => 'nullable|in:minute,hourly,daily,weekly,monthly,yearly',
            'metadata' => 'nullable|array',
        ]);
    }

    protected function handleAttachments(Request $request, $model, $type)
    {
        if ($request->hasFile($type)) {
            foreach ($request->file($type) as $file) {
                $path = $file->store($type, 'public');
                $model->{$type}()->create([
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getClientMimeType(),
                ]);
            }
        }
    }

    protected function handleMetadata(Request $request, $event)
    {
        if ($request->has('metadata')) {
            foreach ($request->input('metadata') as $key => $value) {
                $event->metadata()->updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }
        }
    }
}