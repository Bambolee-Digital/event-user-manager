# Event User Manager

[Português](#gerenciador-de-eventos-de-usuário)

Event User Manager is a Laravel package for managing user events with support for recurrence, attachments, and integration with Filament for administration.

## Installation

You can install the package via composer:

```bash
composer require bambolee-digital/event-user-manager
```

This package depends on spatie/laravel-translatable. If you haven't already installed it, you can do so by running:

```bash
composer require spatie/laravel-translatable
```

## Configuration

Publish the configuration file with:

```bash
php artisan vendor:publish --provider="BamboleeDigital\EventUserManager\EventUserManagerServiceProvider" --tag="config"
```

This will create a `config/event-user-manager.php` file. You can modify the settings as needed.


You will need to register the following resources in your filament configuration file:

```php
    use BamboleeDigital\EventUserManager\Filament\Resources\EventResource;
    use BamboleeDigital\EventUserManager\Filament\Resources\EventTypeResource;
    use BamboleeDigital\OnboardingPackage\Filament\Resources\QuestionResource;

    ->resources([
        EventResource::class,
        EventTypeResource::class,
        RecurrencePatternResource::class,
    ])
```

## Usage

### API

The package provides API endpoints for managing events, notes, attachments, and images. The main endpoints are:

#### Events
- `GET /api/events`: List events
- `POST /api/events`: Create a new event
- `GET /api/events/{id}`: Get event details
- `PUT /api/events/{id}`: Update an event
- `DELETE /api/events/{id}`: Delete an event
- `GET /api/events/past`: Get past events
- `GET /api/events/future`: Get future events
- `GET /api/events/status/{status}`: Get events by status

#### Notes
- `POST /api/events/{event}/notes`: Add a note to an event
- `PUT /api/events/{event}/notes/{note}`: Update a note
- `DELETE /api/events/{event}/notes/{note}`: Delete a note

#### Attachments and Images
- `POST /api/events/{event}/attachments`: Add an attachment to an event
- `DELETE /api/events/{event}/attachments/{attachment}`: Remove an attachment from an event
- `POST /api/events/{event}/images`: Add an image to an event
- `DELETE /api/events/{event}/images/{image}`: Remove an image from an event

# API Usage Examples

Here are comprehensive examples for using the Event User Manager API. These examples use the Guzzle HTTP client, but you can adapt them to your preferred HTTP client.

## Setup

First, set up the HTTP client:

```php
use GuzzleHttp\Client;

$client = new Client([
    'base_uri' => 'http://your-api-base-url/',
    'headers' => [
        'Authorization' => 'Bearer YOUR_API_TOKEN',
        'Accept' => 'application/json',
    ],
]);
```

## Events

### List Events

```php
$response = $client->get('api/events');
$events = json_decode($response->getBody(), true);
```

### Create a Comprehensive Event

```php
$multipart = [
    ['name' => 'name', 'contents' => 'Annual Company Retreat'],
    ['name' => 'description', 'contents' => 'Our yearly company-wide retreat for team building and strategy planning.'],
    ['name' => 'event_type_id', 'contents' => '1'],
    ['name' => 'start_date', 'contents' => '2024-07-15 09:00:00'],
    ['name' => 'end_date', 'contents' => '2024-07-17 17:00:00'],
    ['name' => 'status', 'contents' => 'active'],
    ['name' => 'recurrence_pattern_id', 'contents' => '2'],
    ['name' => 'frequency_type', 'contents' => 'yearly'],
    ['name' => 'frequency_count', 'contents' => '5'],
    ['name' => 'metadata[location]', 'contents' => 'Mountain Resort'],
    ['name' => 'metadata[expected_attendees]', 'contents' => '150'],
    [
        'name' => 'attachments[]',
        'contents' => fopen('path/to/schedule.pdf', 'r'),
        'filename' => 'retreat_schedule.pdf',
    ],
    [
        'name' => 'images[]',
        'contents' => fopen('path/to/venue.jpg', 'r'),
        'filename' => 'retreat_venue.jpg',
    ],
    ['name' => 'notes[0][content]', 'contents' => 'Remember to book flight tickets for overseas participants.'],
    [
        'name' => 'notes[0][attachments][]',
        'contents' => fopen('path/to/flight_details.pdf', 'r'),
        'filename' => 'flight_details.pdf',
    ],
];

$response = $client->post('api/events', [
    'multipart' => $multipart,
]);

$eventData = json_decode($response->getBody(), true);
echo "Event created with ID: " . $eventData['id'];
```

### Get Event Details

```php
$eventId = 1;
$response = $client->get("api/events/{$eventId}");
$event = json_decode($response->getBody(), true);
```

### Update an Event

```php
$eventId = 1;
$response = $client->put("api/events/{$eventId}", [
    'json' => [
        'name' => 'Updated Event Name',
        'description' => 'This is an updated description',
        'start_date' => '2024-08-01 10:00:00',
    ],
]);
$updatedEvent = json_decode($response->getBody(), true);
```

### Delete an Event

```php
$eventId = 1;
$response = $client->delete("api/events/{$eventId}");
echo $response->getStatusCode() == 204 ? "Event deleted successfully" : "Failed to delete event";
```

### Get Past Events

```php
$response = $client->get('api/events/past');
$pastEvents = json_decode($response->getBody(), true);
```

### Get Future Events

```php
$response = $client->get('api/events/future');
$futureEvents = json_decode($response->getBody(), true);
```

### Get Events by Status

```php
$status = 'active';
$response = $client->get("api/events/status/{$status}");
$activeEvents = json_decode($response->getBody(), true);
```

## Notes

### Add a Note to an Event

```php
$eventId = 1;
$response = $client->post("api/events/{$eventId}/notes", [
    'json' => [
        'content' => 'This is a new note for the event',
    ],
]);
$note = json_decode($response->getBody(), true);
```

### Update a Note

```php
$eventId = 1;
$noteId = 1;
$response = $client->put("api/events/{$eventId}/notes/{$noteId}", [
    'json' => [
        'content' => 'This is an updated note content',
    ],
]);
$updatedNote = json_decode($response->getBody(), true);
```

### Delete a Note

```php
$eventId = 1;
$noteId = 1;
$response = $client->delete("api/events/{$eventId}/notes/{$noteId}");
echo $response->getStatusCode() == 204 ? "Note deleted successfully" : "Failed to delete note";
```

## Attachments

### Add an Attachment to an Event

```php
$eventId = 1;
$response = $client->post("api/events/{$eventId}/attachments", [
    'multipart' => [
        [
            'name' => 'attachment',
            'contents' => fopen('path/to/document.pdf', 'r'),
            'filename' => 'important_document.pdf',
        ],
    ],
]);
$attachment = json_decode($response->getBody(), true);
```

### Remove an Attachment from an Event

```php
$eventId = 1;
$attachmentId = 1;
$response = $client->delete("api/events/{$eventId}/attachments/{$attachmentId}");
echo $response->getStatusCode() == 204 ? "Attachment removed successfully" : "Failed to remove attachment";
```

## Images

### Add an Image to an Event

```php
$eventId = 1;
$response = $client->post("api/events/{$eventId}/images", [
    'multipart' => [
        [
            'name' => 'image',
            'contents' => fopen('path/to/image.jpg', 'r'),
            'filename' => 'event_image.jpg',
        ],
    ],
]);
$image = json_decode($response->getBody(), true);
```

### Remove an Image from an Event

```php
$eventId = 1;
$imageId = 1;
$response = $client->delete("api/events/{$eventId}/images/{$imageId}");
echo $response->getStatusCode() == 204 ? "Image removed successfully" : "Failed to remove image";
```

These examples cover all the main operations available through the Event User Manager API. Remember to replace `'http://your-api-base-url/'` with your actual API URL and `'YOUR_API_TOKEN'` with a valid authentication token. Also, adjust file paths in the examples to match your local file structure.

This example demonstrates creating an event with:
- Basic event details (name, description, dates, status)
- Event type and recurrence pattern
- Metadata (location and expected attendees)
- Main event attachments and images
- Notes with their own attachments and images

Remember to replace `'http://your-api-base-url/'` with your actual API URL and `'YOUR_API_TOKEN'` with a valid authentication token.

### Filament Admin

The package includes Filament resources for managing events, event types, and recurrence patterns. These will be automatically available in your Filament panel.

### Notifications

The package includes a configurable notification system. You can add custom notification channels by editing the configuration file.

## Customization

You can extend or override any functionality of the package. Refer to the configuration file for customization options.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Contributions are welcome! Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security

If you discover any security-related issues, please email your-email@example.com instead of using the issue tracker.

## Credits

- [Kellvem Barbosa](https://github.com/kellvembarbosa)
- [All Contributors](../../contributors)

## License

The Event User Manager is open-sourced software licensed under the [MIT license](LICENSE.md).