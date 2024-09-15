<?php

namespace BamboleeDigital\EventUserManager\Services;

use Illuminate\Support\Facades\App;

class NotificationService
{
    protected $channels = [];

    public function __construct()
    {
        $this->loadChannels();
    }

    protected function loadChannels()
    {
        $configChannels = config('event-user-manager.notifications.channels', []);
        foreach ($configChannels as $name => $channel) {
            if ($channel['enabled']) {
                $this->channels[$name] = App::make($channel['class']);
            }
        }
    }

    public function notify(string $message, array $data = [], ?string $channel = null): bool
    {
        if ($channel && isset($this->channels[$channel])) {
            return $this->channels[$channel]->send($message, $data);
        }

        foreach ($this->channels as $channel) {
            $channel->send($message, $data);
        }

        return true;
    }
}