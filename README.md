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

### Example: Creating a Comprehensive Event

Here's an example of creating an event with all possible details, including metadata, annotations, attachments, and images:

```php
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\MultipartStream;

$client = new Client([
    'base_uri' => 'http://your-api-base-url/',
    'headers' => [
        'Authorization' => 'Bearer YOUR_API_TOKEN',
        'Accept' => 'application/json',
    ],
]);

$multipart = [
    ['name' => 'name', 'contents' => 'Annual Company Retreat'],
    ['name' => 'description', 'contents' => 'Our yearly company-wide retreat for team building and strategy planning.'],
    ['name' => 'event_type_id', 'contents' => '1'],  // Assuming 1 is the ID for 'Corporate Event' type
    ['name' => 'start_date', 'contents' => '2024-07-15 09:00:00'],
    ['name' => 'end_date', 'contents' => '2024-07-17 17:00:00'],
    ['name' => 'status', 'contents' => 'active'],
    ['name' => 'recurrence_pattern_id', 'contents' => '2'],  // Assuming 2 is the ID for 'Yearly' recurrence
    ['name' => 'frequency_type', 'contents' => 'yearly'],
    ['name' => 'frequency_count', 'contents' => '5'],  // Repeat for 5 years
    
    // Metadata
    ['name' => 'metadata[location]', 'contents' => 'Mountain Resort'],
    ['name' => 'metadata[expected_attendees]', 'contents' => '150'],
    
    // Main event attachments
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
    
    // Notes with their own attachments and images
    ['name' => 'notes[0][content]', 'contents' => 'Remember to book flight tickets for overseas participants.'],
    [
        'name' => 'notes[0][attachments][]',
        'contents' => fopen('path/to/flight_details.pdf', 'r'),
        'filename' => 'flight_details.pdf',
    ],
    
    ['name' => 'notes[1][content]', 'contents' => 'Catering menu for the event.'],
    [
        'name' => 'notes[1][images][]',
        'contents' => fopen('path/to/menu.jpg', 'r'),
        'filename' => 'catering_menu.jpg',
    ],
];

$response = $client->post('api/events', [
    'multipart' => $multipart,
]);

$eventData = json_decode($response->getBody(), true);
echo "Event created with ID: " . $eventData['id'];
```

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

---

# Gerenciador de Eventos de Usuário

[English](#event-user-manager)

O Gerenciador de Eventos de Usuário é um pacote Laravel para gerenciar eventos de usuários com suporte a recorrência, anexos e integração com o Filament para administração.

## Instalação

Você pode instalar o pacote via composer:

```bash
composer require bambolee-digital/event-user-manager
```

Este pacote depende do spatie/laravel-translatable. Se você ainda não o instalou, pode fazê-lo executando:

```bash
composer require spatie/laravel-translatable
```

## Configuração

Publique o arquivo de configuração com:

```bash
php artisan vendor:publish --provider="BamboleeDigital\EventUserManager\EventUserManagerServiceProvider" --tag="config"
```

Isso criará um arquivo `config/event-user-manager.php`. Você pode modificar as configurações conforme necessário.

## Uso

### API

O pacote fornece endpoints de API para gerenciar eventos, notas, anexos e imagens. Os principais endpoints são:

#### Eventos
- `GET /api/events`: Listar eventos
- `POST /api/events`: Criar um novo evento
- `GET /api/events/{id}`: Obter detalhes de um evento
- `PUT /api/events/{id}`: Atualizar um evento
- `DELETE /api/events/{id}`: Excluir um evento
- `GET /api/events/past`: Obter eventos passados
- `GET /api/events/future`: Obter eventos futuros
- `GET /api/events/status/{status}`: Obter eventos por status

#### Notas
- `POST /api/events/{event}/notes`: Adicionar uma nota a um evento
- `PUT /api/events/{event}/notes/{note}`: Atualizar uma nota
- `DELETE /api/events/{event}/notes/{note}`: Excluir uma nota

#### Anexos e Imagens
- `POST /api/events/{event}/attachments`: Adicionar um anexo a um evento
- `DELETE /api/events/{event}/attachments/{attachment}`: Remover um anexo de um evento
- `POST /api/events/{event}/images`: Adicionar uma imagem a um evento
- `DELETE /api/events/{event}/images/{image}`: Remover uma imagem de um evento

### Exemplo: Criando um Evento Completo

Aqui está um exemplo de criação de um evento com todos os detalhes possíveis, incluindo metadados, anotações, anexos e imagens:

```php
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\MultipartStream;

$client = new Client([
    'base_uri' => 'http://sua-url-base-da-api/',
    'headers' => [
        'Authorization' => 'Bearer SEU_TOKEN_DE_API',
        'Accept' => 'application/json',
    ],
]);

$multipart = [
    ['name' => 'name', 'contents' => 'Retiro Anual da Empresa'],
    ['name' => 'description', 'contents' => 'Nosso retiro anual para toda a empresa para construção de equipe e planejamento estratégico.'],
    ['name' => 'event_type_id', 'contents' => '1'],  // Supondo que 1 é o ID para o tipo 'Evento Corporativo'
    ['name' => 'start_date', 'contents' => '2024-07-15 09:00:00'],
    ['name' => 'end_date', 'contents' => '2024-07-17 17:00:00'],
    ['name' => 'status', 'contents' => 'active'],
    ['name' => 'recurrence_pattern_id', 'contents' => '2'],  // Supondo que 2 é o ID para recorrência 'Anual'
    ['name' => 'frequency_type', 'contents' => 'yearly'],
    ['name' => 'frequency_count', 'contents' => '5'],  // Repetir por 5 anos
    
    // Metadados
    ['name' => 'metadata[location]', 'contents' => 'Resort na Montanha'],
    ['name' => 'metadata[expected_attendees]', 'contents' => '150'],
    
    // Anexos principais do evento
    [
        'name' => 'attachments[]',
        'contents' => fopen('caminho/para/cronograma.pdf', 'r'),
        'filename' => 'cronograma_retiro.pdf',
    ],
    [
        'name' => 'images[]',
        'contents' => fopen('caminho/para/local.jpg', 'r'),
        'filename' => 'local_retiro.jpg',
    ],
    
    // Notas com seus próprios anexos e imagens
    ['name' => 'notes[0][content]', 'contents' => 'Lembrar de reservar passagens aéreas para participantes internacionais.'],
    [
        'name' => 'notes[0][attachments][]',
        'contents' => fopen('caminho/para/detalhes_voo.pdf', 'r'),
        'filename' => 'detalhes_voo.pdf',
    ],
    
    ['name' => 'notes[1][content]', 'contents' => 'Menu de catering para o evento.'],
    [
        'name' => 'notes[1][images][]',
        'contents' => fopen('caminho/para/menu.jpg', 'r'),
        'filename' => 'menu_catering.jpg',
    ],
];

$response = $client->post('api/events', [
    'multipart' => $multipart,
]);

$eventData = json_decode($response->getBody(), true);
echo "Evento criado com ID: " . $eventData['id'];
```

Este exemplo demonstra a criação de um evento com:
- Detalhes básicos do evento (nome, descrição, datas, status)
- Tipo de evento e padrão de recorrência
- Metadados (localização e número esperado de participantes)
- Anexos e imagens principais do evento
- Notas com seus próprios anexos e imagens

Lembre-se de substituir `'http://sua-url-base-da-api/'` pela URL real da sua API e `'SEU_TOKEN_DE_API'` por um token de autenticação válido.

### Painel de Administração Filament

O pacote inclui recursos do Filament para gerenciar eventos, tipos de eventos e padrões de recorrência. Estes estarão disponíveis automaticamente no seu painel Filament.

### Notificações

O pacote inclui um sistema de notificações configurável. Você pode adicionar canais de notificação personalizados editando o arquivo de configuração.

## Personalização

Você pode estender ou substituir qualquer funcionalidade do pacote. Consulte o arquivo de configuração para opções de personalização.

## Testes

```bash
composer test
```

## Changelog

Por favor, veja o arquivo [CHANGELOG](CHANGELOG.md) para mais informações sobre o que mudou recentemente.

## Contribuindo

Contribuições são bem-vindas! Por favor, veja [CONTRIBUTING](.github/CONTRIBUTING.md) para detalhes.

## Segurança

Se você descobrir algum problema relacionado à segurança, por favor envie um e-mail para seu-email@exemplo.com em vez de usar o issue tracker.

## Créditos

- [Kellvem Barbosa](https://github.com/kellvembarbosa)
- [Todos os Contribuidores](../../contributors)

## Licença

O Gerenciador de Eventos de Usuário é um software de código aberto licenciado sob a [licença MIT](LICENSE.md).