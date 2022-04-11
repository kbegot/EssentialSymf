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
### Mettre à jours les dépendances avec composer
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
### Accéder à l'adresse local sur le port 8000
http://127.0.0.1:8000


# Mise en production
### Dérogation du pare-feu
Pour mettre en production le projet vous devez ouvrir le port 80 ou autoriser l'executable httpd.exe trouvable dans
```
C:\wamp64\bin\apache\apache2.4.51\bin
```
voir guide
https://alcatiz.developpez.com/tutoriel/installer-wamp-windows10/#LIV-A

### Modification de httpd-vhosts.conf
Vous devrez ouvrir le fichier httpd-vhosts.conf trouvable dans
```
C:\wamp64\bin\apache\apache2.4.51\conf\extra
```
et le modifier comme ceci
```
# Virtual Hosts
#
<VirtualHost *:80>
  ServerName localhost
  ServerAlias localhost
  DocumentRoot "${INSTALL_DIR}/www/public"
  <Directory "${INSTALL_DIR}/www/public">
    Options +Indexes +Includes +FollowSymLinks +MultiViews
    AllowOverride All
    Require all granted
  </Directory>
</VirtualHost>
```

# Commande utiles au développement
### Lancer le serveur de développement
```
php bin/console server:run
```
### Lancer le serveur de dump (déboguage)
```
php bin/console server:dump
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
