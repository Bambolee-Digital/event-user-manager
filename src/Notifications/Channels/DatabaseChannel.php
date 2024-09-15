<?php

namespace BamboleeDigital\EventUserManager\Notifications\Channels;

use BamboleeDigital\EventUserManager\Contracts\NotificationChannel;
use Illuminate\Support\Facades\DB;

class DatabaseChannel implements NotificationChannel
{
    public function send(string $message, array $data = []): bool
    {
        DB::table(config('event-user-manager.notifications.table', 'notifications'))->insert([
            'type' => 'event_notification',
            'notifiable_type' => $data['notifiable_type'] ?? config('event-user-manager.user_model'),
            'notifiable_id' => $data['notifiable_id'] ?? $data['user_id'] ?? null,
            'data' => json_encode([
                'message' => $message,
                'event_id' => $data['event_id'] ?? null,
                'additional_data' => $data,
            ]),
            'read_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return true;
    }
}