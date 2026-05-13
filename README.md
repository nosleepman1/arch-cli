# Laravel Arch CLI

A Laravel package that extends native Artisan commands to generate complete backend architecture from business models, organized in a clean structure.

## Installation

```bash
composer require nosleepman/laravel-arch-cli
```

## Usage

```bash
php artisan arch:module Project --full
```

This will interactively ask for details and generate:

- Model
- Migration
- Service (optional)
- API Controller (versioned)
- Store/Update Requests (optional)
- Policy (optional)

## Features

- Utilise les commandes Artisan natives de Laravel (make:model, make:migration, make:controller --api, make:request, make:policy)
- Organise les fichiers dans des sous-dossiers appropriés (Requests/ModelName/, Controllers/API/V1/)
- Génère une couche service personnalisée avec injection de dépendances
- Controllers API versionnés avec utilisation des Form Requests
- Politiques d'autorisation

## License

MIT