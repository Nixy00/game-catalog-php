# SAE 2-01 - Développement d'une application

---
### Auteurs
- Yacine MOUNSI : moun0023
- Matteo GODART : goda0054

## Installation / Configuration
Avant de commencer, ce projet est disponible tant bien sur Linux que sur Windows, vous pouvez copier-coller les lignes de codes que ce soit sur Linux ou Windows, sauf indication contraire.

Premièrement vous aurez besoin de cloner le dépôt Git pour avoir accès au projet. Vous pouvez cloner ce dépot grâce à la ligne de code ci-dessous :

    git clone https://iut-info.univ-reims.fr/gitlab/moun0023/sae2-01.git
Ensuite pour finir le clonage vous aurez besoin de vous identifier, exemple :

    Username for 'https://iut-info.univ-reims.fr' : [Insérer votre Login]
    Password for 'https://iut-info.univ-reims.fr' : [Insérer votre Mot De Passe]

Pour pouvoir lancer le site grâce au serveur Web interne du moteur PHP, vous aurez besoin d'installer un package nommé Composer. Pour ce faire, vous pouvez l'installer via grâce à ce lien : https://getcomposer.org/download/

Pour installer les dépendances via Composer, il vous suffit de copier-coller ce bout de code :

    composer dump-autoload
Ce qui vous permet de charger vendor pour avoir accès à autoload.

#### Serveur Web Local

Pour lancer le serveur local, commencer par aller dans un terminal. Ensuite, diriger vous vers le dossier cloné dans votre terminale puis lancer cette commande qui grâce à composer permet d'utiliser le serveur WEB interne du moteur PHP :

Linux :

    composer start:linux

Ou :

    composer start

Windows :

    composer start:windows

#### Configuration de la base de données

Le fichier .mypdo.ini permet de configurer l'accès à la base de données sans devoir modifier le code source.

Pour avoir accès au site internet, il faudra créer dans la racine du projet un fichier .mypdo.ini.
Voici ce qu'il vous faudra dans ce fichier .mypdo.ini :

    [mypdo]

    dsn = "mysql:host=mysql;dbname=[Insérer votre Login]_game;charset=utf8"
    username = "[Insérer votre Login]"
    password = "[Insérer votre Mot De Passe]"
