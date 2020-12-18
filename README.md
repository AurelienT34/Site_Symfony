# Symfony
PORTAL Pierre
TROUCHE Aurélien
Site -> http://portal-trouche-blog.herokuapp.com/

# – Compte et accès (pour la partie administrateur):

## Administrateur:
Email: aurelien@symfony.com
Mot de passe: aurelien@symfony.com

## Editeur:
Email: editeur@symfony.com
Mot de passe: editeur@symfony.com

## Utilisateur:
Email: test3@symfony.com
Mot de passe: test3@symfony.com

# – Commentaires:
  * Item Controller --> OK
  CRUD --> OK
  timestampable --> OK
  sluggable --> OK
  API --> OK
  API 5 DERNIER ARTICLES POST --> OK
  API 5 DERNIERE ARTICLES GET --> OK
  HERBERGEMENT --> OK
  Securité --> OK
  Roles --> OK
  Bootstrap --> OK

# Fonctionnement:

Seul les editeurs et les administrateur peuvent toucher aux articles (création et modification).
Les utilisateurs peuvent consulter les articles et poster des commentaires.
Utilisation d'un bundle pour l'api et génération d'un json "à la main" sur la page d'acceuil.
Méthodes create et update d'article dans la même fonction du controller.
Utilisation des forms de symfony,Gedmo,Entity,EvenListener.
Sécurisation des routes avec le prefixe des routes.
Gestion de l'unicité des email dans l'entité.
Gestion de la correspondance du mot de passe et de confirmation mot de passe dans l'entité.
Gestion de la taille des attributs dans l'entité.

Les fixtures sont couplés avec la librérie Faker (https://github.com/fzaninotto/Faker) lors de nos tests en local.
Si l'url rentrée  n'est pas bonne ou que l'utilisateur ne dispose pas des droits, alors il est redirigé vers la page d'acceuil.

Pour créer un administrateur ou un editeur il faut d'abbord créer un compte normal puis avec un compte d'admin (aurelien@symfony.com), vous pouvez modifier les droits des utilisateurs.

La recherche fonctionne par catégorie mais pas avec le full text. Cependant la recherche full text fonction avec mySQL et non avec PostgreSQL.

