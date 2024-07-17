Pour créer votre BDD, après avoir créer votre projet et installer tout votre environnement de travail
1- Cmde: symfony console doctrine:database:create

2- Cmde: symfony console

Pour générer automatiquement la class dans le controller et le twig dans template faite la commande ci-dessous
3- Cmde: symfony console make:controller Backend\UserController

 Pour créer la table User, repondre yes, yes partout puis la commande suivante:
4-Cmde: symfony console make:user 

pour créer les champs(colonnes) , puis repondre à la question par le nom que vous voulez donner à votre champs
5- Cmde: symfony console make:entity User

Pour préparer le fichier de migration et ensuite la commande ci-dessous
6- symfony console make:migration

Pour exécuter la migration et tout migrer vers la BDD
7- Cmde: symfony console doctrine:migrations:migrate

Dans config->packages->Security.yaml décommenter la ligne ci-dessous dans access_controller
 - { path: ^/admin, roles: ROLE_ADMIN } 

Pour créer un nouveau controller pour sécuriser notre application
8- symfony console make:controller SecurityController

Pour créer un formulaire
9- Cmde: symfony console make:form , puis tapez: UserType, puis: User




******************  Git et Github  *****************
Ne jamais faire git ini avec symfony.
Créer votre repository
Faire le link entre le git et le github en étend sur la branch (master ou main)
git remote add origin https://github.com/Aissatou2626/sf_e_commerce.git

Puis la branche dev . Déplacez-vous ensuite sur cette branche avec la commande
git branch dev
git checkout dev
git add .
git commit -m 'feat(User): add Création de la BDD et de latable User'