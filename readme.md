# Projet Attributions - Les Moutons
Système de gestion des attributions des cours aux professeurs.

## Tech/ framework used
<b>Built with</b>
- [Laravel](https://laravel.com/)

## Site
https://gestion-attributions.alwaysdata.net/

## Trello
https://trello.com/b/bU3BSFQB/attributions

## Exécution des tests
### Les tests unitaires
```
# Windows
php vendor\phpunit\phpunit\phpunit

# Linux
./vendor/bin/phpunit
```
### Les tests d'intégration
```
php artisan dusk
```
## Installation
Cette courte section vous explique comment installer le projet sur votre machine pour le développement en local.

- Cloner le projet sur votre machine: ```git clone <URL>.git```
- Changer de répertoire courant pour le répertoire racine du projet: ```cd <répertoire du projet>```
- Exécuter ```composer install```
- Copier le ```.env.example``` vers un fichier ```.env```: ```cp .env.example .env```
- Ouvrir le ficher ```.env`` et modifier les valeurs des variables suivantes comme suit:
    - ```DB_DATABASE=<le nom de votre base de données>```
    - ```DB_USERNAME=<le nom de votre compte mysql>```
    - ```DB_PASSWORD=<le mot de passe de votre compte mysql>```
- Exécuter les commandes:
    - ```php artisan key:generate```
    - ```php artisan dusk:install```
    - ```php artisan migrate```
    - ```php artisan serve```