# Contribution à Arch CLI

Merci de l'intérêt que vous portez à la contribution d'Arch CLI. Vos contributions sont essentielles pour améliorer cet outil au sein de la communauté Laravel.

## Code de Conduite

En participant à ce projet, vous acceptez de maintenir un environnement professionnel et accueillant pour l'ensemble des contributeurs.

## Comment Contribuer ?

### Signaler des Bugs

Avant de soumettre un rapport de bug, veuillez vérifier les points suivants :
- Vous utilisez la dernière version du package.
- Le problème n'a pas déjà été signalé dans les tickets GitHub (Issues).

Lors de l'ouverture d'un ticket, veuillez inclure :
- Un titre clair et descriptif.
- Les étapes pour reproduire le comportement.
- Le comportement attendu par rapport au comportement constaté.
- Les détails de l'environnement concerné (versions PHP, Laravel, système d'exploitation).
- Les traces d'exécution (stack traces) ou journaux d'erreurs si applicables.

### Propositions de Fonctionnalités

Toutes les propositions de nouvelles fonctionnalités sont bienvenues. Lors de votre soumission :
- Expliquez le cas d'usage et l'intérêt de cette fonctionnalité pour les autres développeurs.
- Décrivez le fonctionnement envisagé (ex : syntaxe de la commande, options).

### Processus de Pull Request

Veuillez suivre la procédure suivante pour soumettre une Pull Request (PR) :

1. Effectuez un fork du dépôt et créez votre branche à partir de `main`.
2. Veillez à ce que votre code respecte les standards de codage PSR-12.
3. Rédigez des tests unitaires ou d'intégration pour toute correction de bug ou nouvelle fonctionnalité.
4. Exécutez la suite de tests existante pour vous assurer de l'absence de régression.
5. Mettez à jour la documentation dans le répertoire `docs` si vos modifications introduisent de nouvelles commandes, options ou comportements.
6. Soumettez la PR avec une description claire des modifications apportées et le lien vers les tickets associés.

## Configuration pour le Développement

Pour configurer un environnement de développement local :

1. Clonez votre fork du dépôt :
   ```bash
   git clone https://github.com/votre-nom-d-utilisateur/arch-cli.git
   cd /path/to/arch-cli
   ```
2. Installez les dépendances :
   ```bash
   composer install
   ```
3. Exécutez les tests :
   ```bash
   vendor/bin/phpunit
   ```
