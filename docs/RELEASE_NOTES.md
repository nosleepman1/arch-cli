# Release Notes

This document lists the release notes for Arch CLI.

---

## English Release Notes (v1.0.0)

### Introducing Arch CLI

Arch CLI is a developer tool for Laravel designed to eliminate architectural boilerplate. With a single interactive command, you can scaffold out a robust, production-ready backend architecture adhering to the separation of concerns.

### Key Features

- Scaffold Everything in One Command: Generate Models, Migrations, Controllers, Services, Repositories, Form Requests, Resources, Policies, Events, Listeners, and Notifications.
- Service and Repository Pattern: Instantly decoupling business logic from controllers, with optional database layer abstraction.
- Smart Validation Generator: Generates Laravel FormRequest files with dynamic validator rules (including unique table validation).
- Clean Pluralization: Generates clean, grammatically correct API resource collection bindings and repository calls.
- API Versioning: Scaffold controllers into v1, v2, or v3 namespaces out of the box.

### Installation

```bash
composer require nosleepman1/arch-cli
```

### Quick Usage

```bash
php artisan make:module Product
```

---

## Notes de Version - Français (v1.0.0)

### Présentation de Arch CLI

Arch CLI est un outil en ligne de commande pour Laravel conçu pour éliminer l'écriture répétitive de code architectural (boilerplate). Avec une seule commande interactive, générez une architecture backend robuste, prête pour la production et respectant la séparation des responsabilités.

### Fonctionnalités Clés

- Génération Complète en Une Commande : Génère les Modèles, Migrations, Contrôleurs, Services, Repositories, Form Requests, Ressources, Policies, Événements, Écouteurs et Notifications.
- Design Pattern Service & Repository : Sépare la logique métier des contrôleurs, avec une abstraction optionnelle de l'accès aux données.
- Générateur de Règles de Validation : Crée les fichiers FormRequest avec des règles dynamiques (dont la validation unique sur la bonne table de base de données).
- Pluralisation Cohérente : Génère des liaisons et des appels de méthodes de repository conformes aux règles de pluralisation.
- Versionnage d'API : Génère des contrôleurs cloisonnés dans des espaces de noms v1, v2, ou v3.

### Installation

```bash
composer require nosleepman1/arch-cli
```

### Utilisation Rapide

```bash
php artisan make:module Product
```
