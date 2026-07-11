# Arch CLI

A Laravel package to generate a complete, structured backend architecture from business models. 

This package provides Artisan commands to scaffold Models, Migrations, Controllers, Services, Repositories, Policies, Events, Listeners, Notifications, and Resources in a single interactive execution, enforcing clean architecture principles and separation of concerns.

## Documentation

For detailed usage, configuration, and guidelines, please refer to the following documents:

* [English Guide](docs/GUIDE.md) - Complete documentation and usage examples.
* [French Guide (Guide en Français)](docs/GUIDE.fr.md) - Documentation complète en français.
* [French README (README en Français)](docs/README.fr.md) - Présentation générale en français.
* [Contributing Guidelines](docs/CONTRIBUTING.md) - How to contribute to this project.
* [Release Notes](docs/RELEASE_NOTES.md) - Version history and changes.

## Key Features

* Single Command Scaffolding: Create Models, Migrations, versioned Controllers, Services, Repositories, Form Requests, Resources, Policies, Events, Listeners, and Notifications at once.
* Clean Architecture: Automatically isolates business logic within a Service layer and abstracts database access with Repositories.
* Interactive CLI: Prompts guide you through defining fields (name and type), selecting API versions, and choosing which architectural components to generate.
* Smart Form Requests: Generates validation rules dynamically, including proper database uniqueness rules.

## Installation

Install the package via Composer as a development dependency:

```bash
composer require nosleepman1/arch-cli --dev
```

The package service provider will be automatically registered by Laravel Package Discovery.

## Quick Start

To generate a new module, execute the following command:

```bash
php artisan make:module {ModuleName}
```

You will be prompted to:
1. Define database fields in `name:type` format (e.g., `title:string`, `description:text`). Press Enter on an empty line to finish.
2. Select the API controller version (v1, v2, v3).
3. Toggle optional components (Services, Repositories, Policies, Events, Listeners, Notifications).

The package will then generate all files in their standard Laravel directory locations.

## License

This package is open-source software licensed under the MIT License. See the [LICENSE](LICENSE) file for more information.
