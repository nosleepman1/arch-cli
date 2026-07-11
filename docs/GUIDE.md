# Arch CLI - Complete Guide

Welcome to the comprehensive guide for Arch CLI. This package aims to drastically reduce boilerplate code when building Laravel applications by scaffolding standard architectural components.

## Table of Contents
1. [Introduction](#introduction)
2. [Generated Components](#generated-components)
3. [Command Walkthrough](#command-walkthrough)
4. [Customization](#customization)

## Introduction
When you run `php artisan make:module User`, the package will automatically generate all necessary layers for a solid backend architecture, enforcing separation of concerns.

## Generated Components

- **Model & Migration**: Standard Laravel models and migrations based on the fields you provide.
- **Controller**: API controllers (versioned, e.g., v1, v2) that can automatically inject service classes.
- **Service Layer**: Handles business logic. Controllers call services instead of writing logic directly.
- **Repository Layer**: Optional abstraction for database queries.
- **Form Requests**: For data validation.
- **API Resources**: For formatting JSON responses.
- **Events & Listeners**: Scaffolded for decoupling tasks (e.g., sending emails after a model is created).
- **Notifications**: Standard Laravel notifications.
- **Policies**: For authorization logic.

## Command Walkthrough

Run:
```bash
php artisan make:module Product
```

**Prompts:**
1. **Enter fields**: Enter your database fields in the `name:type` format (e.g., `title:string`, `price:integer`). Leave empty to finish.
2. **Controller version**: Select the API version (v1, v2, v3).
3. **Include policies?**: Yes/No.
4. **Include service layer?**: Yes/No.
5. **Include events and listeners?**: Yes/No.

After answering, all selected files will be generated in their respective `app/` directories.

## Customization
You can publish and modify the stubs used by the generators if you need to adapt the generated code to your own conventions.
