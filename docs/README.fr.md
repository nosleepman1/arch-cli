# Arch CLI (nosleepman1/arch-cli)

Un package Laravel pour générer une architecture backend complète à partir de modèles métier.
Ce package fournit des commandes artisan pour générer rapidement les Modèles, Migrations, Contrôleurs, Services, Repositories, Policies, Événements, Écouteurs, Notifications et Ressources avec une seule commande.

## Documentation

Veuillez consulter les guides détaillés pour des instructions d'utilisation complètes :
- [Guide de démarrage rapide (Français)](GUIDE.fr.md)
- [Guide de démarrage rapide (English)](GUIDE.md)
- [Guide de contribution](CONTRIBUTING.fr.md)
- [Notes de version](RELEASE_NOTES.md)
- [README Principal (English)](../README.md)

## Démarrage Rapide

### Installation

Installez le package via composer :
```bash
composer require nosleepman1/arch-cli
```

Le "service provider" sera enregistré automatiquement.

### Utilisation

Exécutez la commande de génération de module :
```bash
php artisan make:module {NomDuModule}
```
L'invite de commande vous demandera de définir les champs, la version de contrôleur d'API à cibler, ainsi que les composants optionnels à inclure.
