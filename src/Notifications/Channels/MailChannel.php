<?php

namespace BamboleeDigital\EventUserManager\Notifications\Channels;

use BamboleeDigital\EventUserManager\Contracts\NotificationChannel;
use Illuminate\Support\Facades\Mail;

class MailChannel implements NotificationChannel
{
    public function send(string $message, array $data = []): bool
    {
        $to = $data['email'] ?? config('event-user-manager.notifications.default_email');
        $subject = $data['subject'] ?? 'Event Notification';

        Mail::raw($message, function ($message) use ($to, $subject) {
            $message->to($to)->subject($subject);
        });

        return true;
    }
}