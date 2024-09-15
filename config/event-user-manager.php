<?php

return [
    'supported_locales' => [
        'en',
        'es',
        'pt'
    ],

    'middleware' => [
        'api' => ['api', 'auth:sanctum'],
        'web' => ['web', 'auth'],
    ],

    'routes' => [
        'prefix' => 'api/events',
        'middleware' => 'api',
    ],

    'models' => [
        'event' => BamboleeDigital\EventUserManager\Models\Event::class,
        'event_type' => BamboleeDigital\EventUserManager\Models\EventType::class,
        'event_note' => BamboleeDigital\EventUserManager\Models\EventNote::class,
        'event_metadata' => BamboleeDigital\EventUserManager\Models\EventMetadata::class,
        'recurrence_pattern' => BamboleeDigital\EventUserManager\Models\RecurrencePattern::class,
        'attachment' => BamboleeDigital\EventUserManager\Models\Attachment::class,
        'image' => BamboleeDigital\EventUserManager\Models\Image::class,
    ],

    'tables' => [
        'events' => 'events',
        'event_types' => 'event_types',
        'event_notes' => 'event_notes',
        'event_metadata' => 'event_metadata',
        'recurrence_patterns' => 'recurrence_patterns',
        'attachments' => 'attachments',
        'images' => 'images',
    ],

    'filament' => [
        'enabled' => true,
        'navigation_group' => 'Event Management',
        'resources_path' => 'BamboleeDigital\\EventUserManager\\Filament\\Resources\\Panel',
    ],

    'notifications' => [
        'enabled' => true,
        'channels' => [
            'mail' => [
                'enabled' => true,
                'class' => BamboleeDigital\EventUserManager\Notifications\Channels\MailChannel::class,
            ],
            'database' => [
                'enabled' => true,
                'class' => BamboleeDigital\EventUserManager\Notifications\Channels\DatabaseChannel::class,
            ],
        ],
    ],

    'recurrence' => [
        'max_instances' => 100,
        'lookahead_period' => '1 year',
    ],

    'pagination' => [
        'per_page' => 15,
    ],

    'throttle' => [
        'enabled' => true,
        'max_attempts' => 60,
        'decay_minutes' => 1,
    ],

    'cache' => [
        'enabled' => true,
        'ttl' => 3600,
    ],

    'logging' => [
        'enabled' => true,
        'channel' => 'event-user-manager',
    ],

    'user_model' => \App\Models\User::class,

    'policies' => [
        'event' => BamboleeDigital\EventUserManager\Policies\EventPolicy::class,
    ],
];