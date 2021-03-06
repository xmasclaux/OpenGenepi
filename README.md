# OpenGenepi
Service en ligne de gestion d'espaces publics (EPN) et d'analyse de statistiques

Cette documentation est destinée aux futurs utilisateurs de GENEPI, qui désirent procéder à son installation.. Elle contient toutes les informations nécessaires à la bonne utilisation de ce logiciel.

Elle est en constante évolution : n'hésitez donc pas à revenir souvent consulter cette page.

Cette documentation va vous guider dans l'installation de GENEPI sur votre serveur Web, de type WAMP ou LAMP. Elle se décompose en trois chapitres :

Indications générales : cette partie s'adresse aux utilisateurs avancés possédant déjà un serveur. Les informations exhaustives concernant l'installation sont énoncées ici. Ces indications concernent tous les types de serveur et de systèmes d'exploitation.
Installation sous Linux : cette partie s'adresse aux utilisateurs novices sous Linux. Elle présente l'utilisation d'un script d'installation guidé, prévu pour les systèmes d'exploitation Fedora, Mandriva, Ubuntu et Debian.
Installation sous Windows : cette partie s'adresse aux utilisateurs novices sous Windows. Elle explique les différentes étapes à réaliser afin d'installer WAMPServer 2 et l'application GENEPI. Cette procédure a été réalisée sur Windows XP, Vista et 7.

Si vous êtes un utilisateur avancé et que vous avez déjà installé ou développé des applications Web, nous vous conseillons de suivre le chapitre Indications générales.

Si vous êtes un utilisateur novice, les deux chapitres d'installation (à choisir selon le système d'exploitation de votre serveur) sont faits pour vous.
## indications générales
Durant l'installation classique de GENEPI, les actions suivantes vont être exécutées :

    . installation de WAMP (Windows) ou LAMP (Linux)
    . copie des sources vers le répertoire www
    . création d'un VirtualHost dont la racine est le répertoire Web des sources
    . ajout de l'hôte au fichier hosts sur les machines clientes ou configuration du DNS
    . création de la base de données
    . remplissage de la base de données par importation d'un des scripts SQL
        - empty_EN.sql.zip : données indispensables à GENEPI en français.
        - empty_FR.sql.zip : données indispensables à GENEPI en anglais.
        - demo.sql.zip : script à importer après l'un des deux scripts précédents. Il contient des données de démonstration en français.
    . activation du module rewrite d'Apache 2
    . modification de la memory_limit de PHP
    . activation des modules PHP suivants: php-dom, php-zip, php-xml, php-gd2
    . configuration de l'application via le navigateur.

Si vous êtes familiers avec les serveurs Apache, vous pouvez réaliser l'ensemble de ces actions « à la main », sans passer par le script d'installation.

Détails de ces opérations :

1ère étape :

Installez WAMP (pour Windows, l'exécutable est téléchargeable à l'adresse http://www.wampserver.com/) ou LAMP (pour Linux, une version doit exister dans les dépôts). Si vous possédez déjà un serveur dédié ou que vous possédez déjà LAMP ou WAMP sur votre machine, sautez cette étape.

2e étape :

Dézippez les sources vers le répertoire désiré. Dans la suite de l'installation, nous nommerons ce répertoire REPERTOIRE_INSTALL (chemin du répertoire depuis la racine du système de fichiers). Nous vous recommandons d'utiliser le répertoire www d'Apache 2.

Allez avec la console dans ce répertoire d'installation, et configurez les droits suivants :

chmod 755 -R REPERTOIRE_INSTALL/GENEPI/

chmod 777 REPERTOIRE_INSTALL/GENEPI/log REPERTOIRE_INSTALL/GENEPI/cache REPERTOIRE_INSTALL/GENEPI/web REPERTOIRE_INSTALL/GENEPI/web/index.php REPERTOIRE_INSTALL/GENEPI/web/genepi.php

chmod 777 -R REPERTOIRE_INSTALL/GENEPI/web/uploads REPERTOIRE_INSTALL/GENEPI/config

3e étape :

Ajoutez le VirtualHost suivant (nous recommandons genepi comme nom de serveur) :

<VirtualHost *:80>
    ServerName genepi
    DocumentRoot "c:\wamp\www\genepi\web"
    DirectoryIndex index.php

    <Directory "c:\wamp\www\genepi\web">
        AllowOverride All
        Allow from All
        Order Allow,deny
    </Directory>

    Alias /sf c:\wamp\www\genepi\lib\vendor\symfony\data\web\sf
    <Directory "c:\wamp\www\genepi\lib\vendor\symfony\data\web\sf">
        AllowOverride All
        Allow from All
    </Directory>
</VirtualHost>

4e étape :

Ajoutez la ligne suivante au fichier hosts du poste chaque animateur (si le serveur se trouve sur votre machine, utiliser 127.0.0.1) :

ADRESSE_IP_DU_SERVEUR NOM_DU_SERVEUR

5e étape :

Allez sur PHPMyAdmin et créez une base de données nommée GENEPI. Il est conseillé de créer un utilisateur propre à cette base. Il doit avoir tous les droits sur cette base. Ensuite, importer le script SQL empty... désiré (à récupérer sur la page SourceForge de GENEPI). Si vous désirez disposer de données de démonstration, vous pouvez aussi importer le script demo.sql.zip (après avoir importé l'un des deux scripts empty...).

6e étape :

Il faut préciser à votre navigateur Web d'ignorer NOM_DU_SERVEUR, c'est-à-dire de chercher son adresse IP non pas par DNS mais grâce au fichier hosts.

7e étape :

Activez le module rewrite d'Apache 2, puis redémarrez Apache 2.

8e étape :

Ouvrez le fichier php.ini, et vérifiez que la ligne memory_limit corresponde à celle-ci :

memory_limit = 128M

9e étape :

Activez les modules PHP suivants: php-dom, php-zip, php-xml, php-gd2, puis redémarrez Apache 2.

10e étape :

Accédez à l'URL http://genepi et configurez l'application.

## Installation sous Linux
Afin de pouvoir utiliser GENEPI, vous devez auparavant soit disposer d'un serveur Web dédié, soit avoir préalablement installé LAMP. LAMP est un acronyme désignant un ensemble de logiciels libres permettant de construire des serveurs de sites Web. Pour en savoir, cliquez ici.

Pour les distributions Debian ou Ubuntu, la commande pour installer LAMP est :
sudo apt-get install lamp-server^
Pour Fedora, il faut entrer :

yum install httpd mysql mysql-server phpmyadmin

Enfin, pour les distributions Mandriva, utilisez la commande :

urpmi task-lamp-php

Une fois que vous disposez d'un serveur, il vous faut télécharger GENEPI. Pour cela, rendez-vous sur http://sourceforge.net/projects/genepi/, et cliquez sur Download. Vous aurez aussi besoin des fichiers SQL nécessaires à la création de la base de données. Ces derniers se trouvent dans http://sourceforge.net/projects/genepi/files, dans la partie sql. Si vous souhaitez créer la base en français, téléchargez le fichier empty_FR.version.sql.zip. Si vous souhaitez créer la base en anglais, téléchargez le fichier empty_EN.version.sql.zip. Enfin, si vous voulez que votre base de données contienne des données de démonstration, téléchargez le fichier demo.sql.zip.

Si vous utilisez l'une des distributions Linux précédentes, un script d'aide à l'installation pourra être utilisé, sinon l'installation devra être effectuée manuellement (en utilisant les indications générales présentées précédemment). Ainsi, les distributions supportées par le script sont :

    . Debian
    . Fedora
    . Mandriva
    . Ubuntu.

Pour télécharger le script d'aide à l'installation, allez sur http://sourceforge.net/projects/genepi/files et récupérez l'un des trois fichiers présents sous scripts :

    . scriptInstall_FR : script d'aide à l'installation en français
    . scriptInstall_EN : script d'aide à l'installation en anglais
    . scriptInstall_FR_demo : script d'aide à l'installation en français, avec injection de données de démonstration dans la base de données.

Placez ensuite les sources de l'application (sources.zip) et le script d'aide à l'installation dans un répertoire, et placez le fichier SQL dans un sous-répertoire nommé SQL. Vous pouvez maintenant passer à l'installation de GENEPI.

Pour cela, ouvrez une nouvelle console, connectez-vous en root puis exécutez :

./scriptInstall...

Le script va alors vous guider à travers les différentes étapes de l'installation, à savoir:

    . la copie des sources et la définition des droits sur les fichiers
    . la configuration du serveur Apache2 par VirtualHost
    . l'ajout de genepi à votre fichier hosts
    . la création de la base de données et l'importation des données
    . la création d'un utilisateur MySQL propre à GENEPI.

Une fois le script d'installation achevé, rendez vous à l'adresse indiquée à la fin du script avec votre navigateur pour accéder au logiciel.

Une procédure de configuration vous sera proposée. Elle permettra de configurer les paramètres de la base de données ainsi que de créer un premier administrateur. Une fois la procédure de configuration achevée, vous serez redirigés vers la page d'authentification. Loggez vous alors avec les identifiants de l'administrateur créé. La procédure de configuration ne sera plus accessible, car elle est seulement exécutable lors du premier lancement.

Attention, vous devrez configurer manuellement le paramètre de PHP « memory_limit » du fichier php.ini à 128M. Ce fichier se trouve dans le répertoire /etc/php5/apache2.

De plus, vous devez activer manuellement les modules PHP suivants: php-dom, php-zip, php-xml, php-gd2 (à l'aide de votre gestionnaire de paquets).

## Installation sous Windows

Afin de pouvoir utiliser GENEPI, vous devez disposer d'un serveur Web Apache et d'un serveur de base de données MySQL. WAMPServer 2 est une application regroupant ces deux composants ainsi que PHPMyAdmin (permettant la gestion simplifiée d'une base de donnéees MySQL) et PHP. Pour en savoir plus, vous pouvez vous rendre ici.

Si vous disposez déjà de WAMPServer 2, vous pouvez sauter son téléchargement ainsi que son installation.

Pour commencer, téléchargez puis installez WAMPServer 2 (http://www.wampserver.com/). Cette procédure a été réalisée avec la version 2.0i contenant les versions d'Apache 2.2.11, de MySQL 5.1.36 et de PHP 5.3.0.

Démarrez alors WAMPServer 2.

Pour que son démarrage soit automatique, c'est-à-dire pour qu'il démarre en même temps que votre serveur, copiez-collez le raccourci Start WAMPServer (qui se trouve dans Démarrer/Programmes/WAMPServer) dans le répertoire "Démarrage" du menu Démarrer de Windows (Démarrer/Programmes/Démarrage). WAMPServer 2 sera maintenant exécuté à chaque démarrage de la machine.

Note : Cette manipulation ne fonctionne pas sous Windows 7. Pour que WAMPServer démarre en même temps que votre machine-serveur, suivez les instructions suivantes :

    . cliquez sur Démarrer puis entrez "Services" dans Rechercher
    . cliquez sur l'application Services qui doit vous être proposée
    . repérez alors les services wamapache et wampmysql. Pour chacun d'eux, effectuez un clic droit, puis cliquez sur Propriétés. Dans la boîte de dialogue qui s'ouvre, dans la partie "Type de démarrage", choisissez "automatique". Validez en cliquant sur OK. WAMPServer doit maintenant démarrer à chaque démarrage de votre ordinateur.

Vous voyez maintenant une nouvelle icône apparaître en bas à droite. Cliquez alors sur cette icône. Cela devrait provoquer l'ouverture du menu suivant :

Image 2 - Menu de WAMPServer 2

Ce menu, qui va nous être très utile pour la suite, est appelé un traylcon. Nous utiliserons ce terme dans la suite de la procédure d'installation.

Mettez ensuite WAMPServer 2 en mode "En ligne". Pour cela, cliquez sur le traylcon puis sur Put Online. Votre serveur Apache est maintenant démarré.

Il vous faut maintenant télécharger GENEPI. Pour cela, rendez-vous sur http://sourceforge.net/projects/genepi/, et cliquez sur Download.

Une fois le téléchargement terminé, dézippez le fichier compressé (.zip ou .tar.gz) dans le répertoire C:\wamp\www.

Votre répertoire www doit maintenant contenir un dossier GENEPI et un fichier index.php (accueil de WAMPServer).

Ouvrez maintenant avec un éditeur de texte le fichier httpd.conf présent dans le répertoire C:\wamp\bin\apache\Apache2.2.11\conf. Décommentez la ligne suivante (enlevez le #, cette ligne doit se trouver entre les lignes 160 et 170) :
Include conf/extra/httpd-vhosts.conf

Fermez ce fichier.

Ouvrez ensuite avec un éditeur de texte le fichier C:\wamp\bin\apache\Apache2.2.11\conf\extra\httpd-vhosts.conf. Ajoutez les lignes suivantes à la fin de ce fichier :

<VirtualHost *:80>
    ServerName genepi
    DocumentRoot "c:\wamp\www\genepi\web"
    DirectoryIndex index.php

    <Directory "c:\wamp\www\genepi\web">
        AllowOverride All
        Allow from All
        Order Allow,deny
    </Directory>

    Alias /sf c:\wamp\www\genepi\lib\vendor\symfony\data\web\sf
    <Directory "c:\wamp\www\genepi\lib\vendor\symfony\data\web\sf">
        AllowOverride All
        Allow from All
    </Directory>
</VirtualHost>

 

Ensuite, nous allons ajouter l'hôte genepi à votre fichier hosts. Pour cela, allez dans C:\Windows\System 32\drivers\etc et ouvrez le fichier hosts. Ajoutez la ligne suivante :
127.0.0.1 genepi

Cette manipulation doit aussi être effectuée sur tous les postes qui vont utiliser GENEPI. Dans ce cas, il faut remplacer 127.0.0.1 par l'adresse IP du serveur. Par exemple, si l'adresse IP du serveur est 192.168.0.1, il vous faudra entrer sur chacune des machines (excepté le serveur) :

192.168.0.1 genepi

Pour connaître l'adresse IP de votre serveur, cliquez sur Démarrer, puis Exécuter. Entrez alors cmd, puis tapez sur Entrer. Dans la console qui s'affiche, tapez ipconfig puis Entrée. Repérez le bloc correspondant à la carte réseau connectée à votre réseau local. L'adresse IP de votre serveur se trouve en face de la ligne IP Address.

Par exemple, sur l'image suivante, l'adresse IP de l'interface est 130.64.251.198 :

ipconfig

Image 3 - Résultat de la commande ipconfig

Il faut maintenant passer à la création de la base de données. Pour cela, aller à l'adresse http://localhost/phpmyadmin avec votre navigateur, puis créer la base de données suivante :

Nom : GENEPI

Interclassement : utf8_unicode_ci

Puis cliquez sur Créer. La base de données est maintenant créée. Nous allons maintenant créer un utilisateur MySQL sur cette base de données. Pour cela, aller dans Privilèges, puis cliquez sur Ajouter un utilisateur.

Entrez alors les informations suivantes :

Nom d'utilisateur : entrez le nom que vous voulez

Serveur : Tout serveur

Mot de passe : entrez le mot de passe que vous voulez

Dans "Base de données pour cet utilisateur", cliquez sur Aucune.

Dans "Privilèges globaux", cliquez sur Tout décocher.

Enfin, cliquez sur Exécuter.

Vous êtes redirigé sur la page de changement des privilèges de l'utilisateur créé. Dans la section "Privilèges spécifiques à une base de données", sélectionnez "GENEPI", puis cliquez sur "Exécuter". Enfin, cliquez sur "Tout cocher" puis "Exécuter". Cet utilisateur MySQL (ou compte MySQL) sera utilisé par l'application GENEPI pour se connecter à la base de données.

Nous allons maintenant télécharger les scripts SQL de création et de remplissage des tables de la base de données. Pour cela, allez sur http://sourceforge.net/projects/genepi/ puis View all files. Sous le dossier sql, trois fichiers doivent être présents :

    . empty_FR.version.sql.zip : données indispensables à GENEPI en français.
    . empty_EN.version.sql.zip : données indispensables à GENEPI en anglais.
    . demo.version.sql.zip : données de démonstration en français.

Il vous faut donc télécharger le fichier empty..sql.zip correspondant à votre langue. De même, si vous voulez disposer d'une base de données pré-remplie, téléchargez aussi le fichier demo.version.sql.zip.

Une fois ce ou ces fichiers téléchargés, il faut les importer dans la base de données.

Pour cela, cliquez sur la base de données GENEPI, allez dans importer puis importez le fichier compressé empty..sql.zip.

Si vous souhaitez avoir des données de démonstration, importez ensuite de la même façon le fichier demo.version.sql.zip.

Le remplissage de la base de données est maintenant terminé. Nous allons passer à la dernière partie : la configuration des modules d'Apache 2 et de PHP.

GENEPI nécessite l'activation du module rewrite d'Apache 2. Pour cela, ouvrez le « Traylcon » et cliquez sur Apache, Apache Modules puis Rewrite_module.

Il faut ensuite modifier le fichier de configuration de PHP. Pour cela, ouvrir le « Traylcon » et cliquer sur PHP puis php.ini.

PHP.ini

Image 4 - Ouverture du fichier php.ini

Remplacez la ligne :

memory_limit = …M

Par :

memory_limit = 128M

Il faut maintenant activer certains modules PHP. Pour cela, cliquez sur le traylcon, sur PHP, puis sur PHP extensions. Cliquez alors sur les modules PHP suivants :

    . php_dom
    . php_gd2
    . php_zip

Redémarrez alors WAMPServer (clic sur le Traylcon puis "Restart All Services").

Enfin, avec votre navigateur web, allez sur http://genepi, puis laissez-vous guider par la procédure de configuration. Vous aurez besoin de l'identifiant et du mot de passe de l'utilisateur MySQL que nous venons de créer.

Cette documentation installateur est maintenant terminée.

Si vous rencontrez une difficulté lors de l'installation, nous vous conseillons de visiter la FAQ, ou de poser une question.
