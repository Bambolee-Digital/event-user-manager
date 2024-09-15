<?php

namespace BamboleeDigital\EventUserManager\Contracts;

interface NotificationChannel
{
    public function send(string $message, array $data = []): bool;
}