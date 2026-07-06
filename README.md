# Arch CLI (nosleepman/module)

A Laravel package to generate a complete backend architecture from business models.
This package provides artisan commands to scaffold Models, Migrations, Controllers, Services, Repositories, Policies, Events, Listeners, Notifications, and Resources with a single command.

## Documentation
Please refer to the detailed guides for complete usage instructions:
- [English Guide](docs/GUIDE.md)
- [Guide en Français](docs/GUIDE.fr.md)
- [README en Français](README.fr.md)

## Quick Start

### Installation

Require the package via composer:
```bash
composer require nosleepman/module
```

The service provider will be automatically registered.

### Usage

Run the module generation command:
```bash
php artisan make:module {ModuleName}
```
You will be prompted to define fields, controller versions, and which components to include.
