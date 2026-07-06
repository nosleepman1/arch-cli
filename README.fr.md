# Arch CLI (nosleepman/module)

Un package Laravel pour générer une architecture backend complète à partir de modèles métier.
Ce package fournit des commandes artisan pour générer rapidement Modèles, Migrations, Contrôleurs, Services, Repositories, Policies, Événements, Écouteurs, Notifications et Ressources avec une seule commande.

## Documentation
Veuillez consulter les guides détaillés pour des instructions d'utilisation complètes :
- [Guide en Français](docs/GUIDE.fr.md)
- [English Guide](docs/GUIDE.md)
- [English README](README.md)

## Démarrage Rapide

### Installation

Installez le package via composer :
```bash
composer require nosleepman/module
```

Le "service provider" sera enregistré automatiquement.

### Utilisation

Exécutez la commande de génération de module :
```bash
php artisan make:module {NomDuModule}
```
Il vous sera demandé de définir les champs, les versions du contrôleur et les composants à inclure.
