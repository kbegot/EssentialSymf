# EssentialSup
## Projet EssentialSup basé sur symphony
# Installation du projet
## Installer composer et les dépendances en local
### Installer wampServer
https://www.wampserver.com
Version PHP: 7.2.34
### Installer composer
https://getcomposer.org/download
## Dans un invite de commande (cmd ou powershell)
```
composer update
```
### (Optionnel) Installer le module de fixture
```
composer require orm-fixtures --dev
```
### Crée la base de donnée en local
```
php bin/console doctrine:database:create
```
### Effectuer les migrations
```
php bin/console doctrine:migrations:migrate
```
### Lancer le serveur de développement
```
php bin/console server:run
```
## Commande utiles au développement
### Lancer le serveur de développement
```
php bin/console server:run
```
### Crée un controller
```
php bin/console make:controller
```
(puis rentrer le nom du controller)
### Crée une nouvelle entité
```
php bin/console make:entity
```
### Crée une migration
```
php bin/console make:migration
```
### Effectuer les migrations
```
php bin/console doctrine:migrations:migrate
```
### Crée une nouvelle fixture
```
php bin/console make:fixtures
```
### Charger les fixtures existante
```
php bin/console doctrine:fixtures:load
```
### Crée un nouveau formulaire (Register)
```
php bin/console make:registration-form
```
### Crée l'authentification
```
php bin/console make:auth
```
