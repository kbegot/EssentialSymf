# EssentialSup
## Projet EssentialSup basé sur symphony



### Installer notre projet depuis un Ordinateur:  
  -Installer composer: https://getcomposer.org/download/  
  -Installer wampServer: https://www.wampserver.com/  
  -Version PHP: 7.2.34 (avec composer)  
  -Commande à rentrer dans le terminal (VS): composer update  
  -Commande à rentrer dans le terminal (VS): composer require server --dev "^4.4.2"  
  
  
  
### Commande utiles:  
  -Commande pour lancer le serveur: php bin/console server:run  
  -Commande pour crée un controller: php bin/console make:controller    (puis rentrer le nom du controller)  
  -Commande pour installer le fixtures: composer require orm-fixtures --dev  
  -Commande pour crée une BDD: php bin/console doctrine:database:create  
  -Commande pour crée une Entity: php bin/console make:entity  
  -Commande pour crée une migration: php bin/console make:migration  
  -Commande pour faire tourner toutes les migrations: php bin/console doctrine:migrations:migrate  
  -Commande pour crée une Fixtures: php bin/console make:fixtures  
  -Commande pour charger nos Fixtures: php bin/console doctrine:fixtures:load  
  -Commane pour crée un formulaire (Register): php bin/console make:registration-form  
  -Commande pour crée l'authentification: php bin/console make:auth  
