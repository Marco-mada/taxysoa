# TaxySoa

Application de réservation de taxi à Madagascar

## Description
TaxySoa est une application web permettant de :
- Réserver un taxi en ligne
- Suivre sa course en temps réel
- Payer directement via l'application
- Évaluer les chauffeurs

## Technologies Utilisées
- Backend : Laravel 10.x
- Frontend : Vue.js 3
- Base de données : MySQL 8.0
- Tests : PHPUnit, Jest
- CI/CD : GitHub Actions

## Installation

1. Cloner le repository
```bash
git clone git@github.com:Marco-mada/taxysoa.git
cd taxysoa
```

2. Installer les dépendances
```bash
composer install
npm install
```

3. Configurer l'environnement
```bash
cp .env.example .env
php artisan key:generate
```

4. Configurer la base de données
- Créer une base de données MySQL
- Modifier le fichier .env avec vos informations
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=taxysoa
DB_USERNAME=root
DB_PASSWORD=votre_mot_de_passe
```

5. Lancer les migrations
```bash
php artisan migrate
```

6. Lancer le serveur
```bash
php artisan serve
npm run dev
```

## Structure du Projet
- `/app` : Code source PHP
- `/resources` : Vues et assets
- `/database` : Migrations et seeders
- `/tests` : Tests automatisés
- `/docs` : Documentation

## Tests
```bash
# Tests PHP
php artisan test

# Tests JavaScript
npm run test
```

## Contribution
1. Créer une branche pour votre fonctionnalité
```bash
git checkout -b feature/nom-fonctionnalite
```

2. Développer et tester
```bash
# Lancer les tests
php artisan test
npm run test
```

3. Créer une pull request
- Pousser votre branche
- Aller sur GitHub
- Créer une Pull Request vers develop

4. Attendre la revue de code
- Les tests automatiques s'exécutent
- Un reviewer doit approuver
- Le merge sera possible si tout est vert

## Déploiement
Le déploiement est automatique :
- `develop` -> environnement de staging
- `main` -> environnement de production

## Contact
- Email : admin@taxysoa.net
- Site : https://taxysoa.com
