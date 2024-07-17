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





Ne jamais faire git ini avec symfony.
Créer votre repository, puis la branche dev . Déplacez-vous ensuite sur cette branche avec la commande
git branch dev
git checkout dev