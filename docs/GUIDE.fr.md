# Arch CLI - Guide Complet

Bienvenue dans le guide complet de Arch CLI. Ce package vise à réduire considérablement le code répétitif (boilerplate) lors de la création d'applications Laravel en générant les composants architecturaux standards.

## Table des Matières
1. [Introduction](#introduction)
2. [Composants Générés](#composants-générés)
3. [Déroulement de la Commande](#déroulement-de-la-commande)
4. [Personnalisation](#personnalisation)

## Introduction
Lorsque vous exécutez `php artisan make:module User`, le package va automatiquement générer toutes les couches nécessaires pour une architecture backend solide, favorisant la séparation des responsabilités.

## Composants Générés

- **Modèle & Migration** : Modèles et migrations standards basés sur les champs fournis.
- **Contrôleur** : Contrôleurs API (versionnés, ex: v1, v2) qui peuvent injecter automatiquement les classes de service.
- **Couche de Service** : Gère la logique métier. Les contrôleurs appellent les services au lieu d'intégrer directement la logique.
- **Couche Repository** : Abstraction optionnelle pour les requêtes de base de données.
- **Form Requests** : Pour la validation des données.
- **API Resources** : Pour le formatage des réponses JSON.
- **Événements & Écouteurs** : Générés pour découpler les tâches (ex: envoyer un e-mail après la création d'un modèle).
- **Notifications** : Notifications standards Laravel.
- **Policies** : Pour la logique d'autorisation.

## Déroulement de la Commande

Exécutez :
```bash
php artisan make:module Product
```

**Invites de commande :**
1. **Enter fields** : Saisissez vos champs de base de données au format `nom:type` (ex : `title:string`, `price:integer`). Laissez vide pour terminer.
2. **Controller version** : Sélectionnez la version de l'API (v1, v2, v3).
3. **Include policies?** : Oui/Non.
4. **Include service layer?** : Oui/Non.
5. **Include events and listeners?** : Oui/Non.

Après avoir répondu, tous les fichiers sélectionnés seront générés dans leurs répertoires `app/` respectifs.

## Personnalisation
Vous pouvez publier et modifier les "stubs" utilisés par les générateurs si vous avez besoin d'adapter le code généré à vos propres conventions.
