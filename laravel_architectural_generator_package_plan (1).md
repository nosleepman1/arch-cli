# Laravel Architectural Generator — plan complet

## Prompt projet

Construire un package pour entity["software","Laravel","PHP framework"] qui ajoute une commande Artisan capable de générer une architecture backend complète à partir d’un modèle métier.

Objectif : dépasser `php artisan make:model --all` en générant automatiquement controllers versionnés, services, requests, policies, events, listeners, notifications et tests selon des choix interactifs.

## Architecture du package

```text
laravel-arch-cli/
├── src/
│   ├── Console/Commands/
│   ├── Generators/
│   ├── Builders/
│   ├── Prompts/
│   ├── Stubs/
│   └── ServiceProvider.php
├── composer.json
├── README.md
└── tests/
```

### Dossiers internes

- Console/Commands → commande artisan principale
- Generators → classes de génération
- Builders → construction namespace/imports
- Prompts → questions interactives
- Stubs → templates php

## Workflow CLI

Commande :

```bash
php artisan arch:module Project --full
```

Questions interactives :

- nom du modèle
- champs
- controller version ? (v1 / v2 / v3)
- service layer ?
- repository ?
- requests ?
- policies ?
- resources ?
- events ?
- listeners ?
- notifications ?
- tests ?

## Phase 1 (MVP)

Générer :

- Model
- Migration
- Service
- API Controller
- Store/Update Request
- Policy

Structure :

```text
app/
├── Models/
├── Services/
├── Http/
│   ├── Controllers/API/V1/
│   └── Requests/Project/
└── Policies/
```

## Phase 2

Ajouter :

- Events
- Listeners
- Notifications
- auto wiring
- event() injection dans service

Exemple :

```php
 event(new ProjectCreated($project, auth()->user()));
```

## Phase 3

Ajouter :

- tests unitaires
- feature tests
- resources
- relations
- factories
- seeders
- repository pattern optionnel

## Exemple service généré

```php
createProject()
getProjects()
getProject()
updateProject()
deleteProject()
```

## Controller versionné

```text
app/Http/Controllers/api/v1/ProjectController.php
app/Http/Controllers/api/v2/ProjectController.php
```

## Transformer en commande artisan

### Service provider

Créer `src/ServiceProvider.php`.

Enregistrer :

- merge config
- publishes
- commands

### Exemple

```php
public function boot(): void
{
    $this->commands([
        GenerateModuleCommand::class,
    ]);
}
```

## composer.json

```json
{
  "name": "abdallah/laravel-arch-cli",
  "autoload": {
    "psr-4": {
      "Abdallah\\ArchCLI\\": "src/"
    }
  },
  "extra": {
    "laravel": {
      "providers": [
        "Abdallah\\ArchCLI\\ServiceProvider"
      ]
    }
  }
}
```

## Publier sur Composer / Packagist

1. Créer repo GitHub
2. push package
3. créer compte Packagist
4. submit repo
5. tag release

Commandes :

```bash
git init
git add .
git commit -m "initial"
git remote add origin <repo>
git push -u origin main
git tag 1.0.0
git push --tags
```

Packagist :

https://packagist.org/packages/submit

Installation ensuite :

```bash
composer require abdallah/laravel-arch-cli
```

## Conseils

Commencer par Phase 1, publier, tester sur 2 projets réels, puis itérer.

Le cœur du projet : qualité des stubs + moteur interactif + conventions cohérentes.

