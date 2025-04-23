# TaxySoa

Application de réservation de taxi à Madagascar

## Description
TaxySoa est une application web permettant de :
- Réserver un taxi en ligne
- Suivre sa course en temps réel
- Payer directement via l'application
- Évaluer les chauffeurs

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

## Contribution
1. Créer une branche pour votre fonctionnalité
2. Développer et tester
3. Créer une pull request
4. Attendre la revue de code

## Contact
- Email : admin@taxysoa.net
- Site : https://taxysoa.com
