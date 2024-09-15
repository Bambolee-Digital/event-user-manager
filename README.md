# Event User Manager

[Português](#gerenciador-de-eventos-de-usuário)

Event User Manager is a Laravel package for managing user events with support for recurrence and integration with Filament for administration.

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

The package provides API endpoints for managing events. The main endpoints are:

- `GET /api/events`: List events
- `POST /api/events`: Create a new event
- `GET /api/events/{id}`: Get event details
- `PUT /api/events/{id}`: Update an event
- `DELETE /api/events/{id}`: Delete an event
- `GET /api/events/past`: Get past events
- `GET /api/events/future`: Get future events
- `GET /api/events/status/{status}`: Get events by status

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

O Gerenciador de Eventos de Usuário é um pacote Laravel para gerenciar eventos de usuários com suporte a recorrência e integração com o Filament para administração.

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

O pacote fornece endpoints de API para gerenciar eventos. Os principais endpoints são:

- `GET /api/events`: Listar eventos
- `POST /api/events`: Criar um novo evento
- `GET /api/events/{id}`: Obter detalhes de um evento
- `PUT /api/events/{id}`: Atualizar um evento
- `DELETE /api/events/{id}`: Excluir um evento
- `GET /api/events/past`: Obter eventos passados
- `GET /api/events/future`: Obter eventos futuros
- `GET /api/events/status/{status}`: Obter eventos por status

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