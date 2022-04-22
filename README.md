# EssentialSup
## Projet EssentialSup basé sur symphony
# Installation du projet
## Installer composer et les dépendances en local
### Installer wampServer
https://www.wampserver.com
Version PHP: 7.2.34
### Installer composer
https://getcomposer.org/download
## Dans un éditeur de text / code
### Configurer l'accès au serveur de base de données
Vous devrez ouvrir le fichier .env et modifier la ligne 30 qui par défaut est
```
DATABASE_URL="mysql://ukfh0518_admin:PqQD-UcpWsq{@127.0.0.1:3306/ukfh0518_essentialsup?serverVersion=mariadb-10.3.28"
```
et la modifier selon le serveur de base de données utilisés, dans le cas ou on utilise wampserver on mettra
```
DATABASE_URL="mysql://root:@127.0.0.1:3306/essentialsup?serverVersion=5.7"
```
## Dans un invite de commande (cmd ou powershell)
### Mettre à jour les dépendances avec composer
```
composer update
```
### (Optionnel) Installer le module de fixture
```
composer require orm-fixtures --dev
```
### Créer la base de données en local
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
### Accéder à l'adresse locale sur le port 8000
http://127.0.0.1:8000


# Mise en production
### Dérogation du pare-feu
Pour mettre en production le projet vous devez ouvrir le port 80 ou autoriser l'éxecutable httpd.exe trouvable dans
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

# Commandes utiles au développement
### Lancer le serveur de développement
```
php bin/console server:run
```
### Lancer le serveur de dump (débogage)
```
php bin/console server:dump
```
### Créer un controller
```
php bin/console make:controller
```
(puis rentrer le nom du controller)
### Créer une nouvelle entité
```
php bin/console make:entity
```
### Créer une migration
```
php bin/console make:migration
```
### Effectuer les migrations
```
php bin/console doctrine:migrations:migrate
```
### Créer une nouvelle fixture
```
php bin/console make:fixtures
```
### Charger les fixtures existantes
```
php bin/console doctrine:fixtures:load
```
### Créer un nouveau formulaire (Register)
```
php bin/console make:registration-form
```
### Créer l'authentification
```
php bin/console make:auth
```
