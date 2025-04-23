# Guide de Configuration - TaxySoa

## Configuration de l'Environnement

### 1. Variables d'Environnement
Créez un fichier `.env` à la racine du projet en copiant `.env.example` :
```bash
cp .env.example .env
```

### 2. Configuration Requise

#### Base de Données
- Créez une base de données MySQL nommée `taxysoa`
- Configurez les variables DB_* dans `.env`

#### Services Externes
- **Google Maps** : Obtenez une clé API pour les cartes
- **Stripe** : Configurez les clés pour les paiements
- **Firebase Cloud Messaging** : Pour les notifications push

### 3. Installation des Dépendances

```bash
# Installer les dépendances PHP
composer install

# Installer les dépendances Node.js
npm install

# Compiler les assets
npm run dev
```

### 4. Configuration Initiale

```bash
# Générer la clé d'application
php artisan key:generate

# Exécuter les migrations
php artisan migrate

# Installer les assets
php artisan storage:link
```

### 5. Services Recommandés

- **Mail** : Utilisez Mailpit pour le développement
- **Cache** : Redis pour la production
- **Queue** : Redis ou database pour la production

### 6. Sécurité

- Ne jamais commiter le fichier `.env`
- Utiliser des clés API sécurisées
- Configurer HTTPS en production
- Mettre à jour régulièrement les dépendances

### 7. Déploiement

- Configurer le serveur web (Apache/Nginx)
- Définir les permissions correctes
- Configurer les cron jobs si nécessaire
- Mettre en place les backups 