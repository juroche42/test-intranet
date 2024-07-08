## API Projet Laravel

- Réalisé par Jules Roche

- API permettant le visionage, la modification et et la suppression d'utilisateurs par un système d'annuaire

## Getting started

Pour commencer, vous devrez installer :

- composer
- php 8.3
- docker

Dans le terminal à la racine du projet, tapez: composer install <br>
Dans le terminal à la racine du projet, tapez: cp .env.example .env <br>

Créez une base de donnée mysql avec le nom de votre choix.

## Installation de la base de données:

Changez le nom de la base de donnée par celui que vous avez choisi dans le fichier ".env" à la ligne DB_DATABASE. <br>
Si besoin:
- Changez le nom d'utilisateur dans le fichier ".env" à la ligne DB_USERNAME
- Changez le mot de passe dans le fichier ".env" à la ligne DB_PASSWORD

## Lancer le DB 

Dans le terminal à la racine, tapez: docker compose up -d

## Rentrer des données fictives:

Dans le terminal à la racine du projet, tapez: php artisan migrate:fresh --seed.<br>

## Tester l'api:

L’api peut être testée sur Postman (ou autre).<br>
Dans le terminal à la racine du projet, tapez: php artisan serve.<br>

## Documentation de l'API

Pour voir les routes et comment les utiliser, une documenation via Swagger UI est disponible.<br>
Aller a la page localhost:8000/swagger/index.html pour voir la liste des routes et modeles.<br>