# Event User Manager

Event User Manager é uma library Laravel para gerenciar eventos de usuários com suporte a recorrência e integração com Filament para administração.

## Instalação

Você pode instalar o pacote via composer:

```bash
composer require bambolee-digital/event-user-manager
```

## Configuração

Publique o arquivo de configuração com:

```bash
php artisan vendor:publish --provider="BamboleeDigital\EventUserManager\EventUserManagerServiceProvider" --tag="config"
```

Isso criará um arquivo `config/event-user-manager.php`. Você pode modificar as configurações conforme necessário.

## Uso

### API

O pacote fornece endpoints de API para gerenciar eventos. Os endpoints principais são:

- `GET /api/events`: Listar eventos
- `POST /api/events`: Criar um novo evento
- `GET /api/events/{id}`: Obter detalhes de um evento
- `PUT /api/events/{id}`: Atualizar um evento
- `DELETE /api/events/{id}`: Excluir um evento

### Filament Admin

O pacote inclui recursos do Filament para gerenciar eventos, tipos de eventos e padrões de recorrência. Estes estarão disponíveis automaticamente no seu painel Filament.

### Notificações

O pacote inclui um sistema de notificações configurável. Você pode adicionar canais de notificação personalizados editando o arquivo de configuração.

## Customização

Você pode estender ou substituir qualquer funcionalidade do pacote. Consulte o arquivo de configuração para opções de customização.

## Testes

```bash
composer test
```

## Changelog

Por favor, veja o arquivo [CHANGELOG](CHANGELOG.md) para mais informações sobre o que mudou recentemente.

## Contribuindo

Contribuições são bem-vindas! Por favor, veja [CONTRIBUTING](.github/CONTRIBUTING.md) para detalhes.

## Segurança

Se você descobrir algum problema relacionado à segurança, por favor envie um e-mail para [seu-email@exemplo.com](mailto:seu-email@exemplo.com) em vez de usar o issue tracker.

## Créditos

- [Seu Nome](https://github.com/seu-username)
- [Todos os Contribuidores](../../contributors)

## Licença

O Event User Manager é um software de código aberto licenciado sob a [licença MIT](LICENSE.md).# event-user-manager
