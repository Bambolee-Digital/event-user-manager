<?php

namespace BamboleeDigital\EventUserManager\Observers;

use BamboleeDigital\EventUserManager\Models\Event;
use Illuminate\Support\Facades\App;

class EventObserver
{
    protected $notificationService;

    public function __construct()
    {
        $this->notificationService = App::make('event-user-manager.notification');
    }

    public function created(Event $event)
    {
        if (config('event-user-manager.notifications.enabled')) {
            $this->notificationService->notify(
                "New event created: {$event->name}",
                ['event_id' => $event->id, 'user_id' => $event->user_id]
            );
        }
    }

    public function updated(Event $event)
    {
        if (config('event-user-manager.notifications.enabled') && $event->isDirty('status')) {
            $this->notificationService->notify(
                "Event status changed to {$event->status}: {$event->name}",
                ['event_id' => $event->id, 'user_id' => $event->user_id]
            );
        }
    }

    public function deleted(Event $event)
    {
        if (config('event-user-manager.notifications.enabled')) {
            $this->notificationService->notify(
                "Event deleted: {$event->name}",
                ['event_id' => $event->id, 'user_id' => $event->user_id]
            );
        }
    }
}