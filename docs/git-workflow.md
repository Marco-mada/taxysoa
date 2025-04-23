# Stratégie Git et CI/CD - TaxySoa

## 1. Gestion des Versions

### Configuration du Repository
```bash
# Structure recommandée
.git/
├── hooks/
│   ├── pre-commit
│   └── pre-push
├── .gitignore
└── .gitattributes
```

### .gitignore
```gitignore
# Laravel
/vendor/
/node_modules/
.env
.env.*
!.env.example
/storage/framework/cache/*
/storage/framework/sessions/*
/storage/framework/views/*
/storage/logs/*
/public/storage

# Vue.js
/dist/
/.vite/
*.log

# IDE
.idea/
.vscode/
*.swp
*.swo

# Tests
/coverage/
.phpunit.result.cache
```

### .gitattributes
```gitattributes
# Configuration des fins de ligne
* text=auto
*.php text eol=lf
*.js text eol=lf
*.vue text eol=lf
*.css text eol=lf
*.scss text eol=lf
*.json text eol=lf
*.md text eol=lf

# Fichiers binaires
*.png binary
*.jpg binary
*.gif binary
*.ico binary
*.pdf binary
```

## 2. Stratégie de Branches

### GitHub Flow (simplifié)
```
main (production)
├── develop (staging)
│   ├── feature/*
│   ├── bugfix/*
│   └── hotfix/*
└── release/*
```

### Types de Branches
1. **main**
   - Branche de production
   - Toujours stable
   - Déploiement automatique

2. **develop**
   - Branche d'intégration
   - Environnement de staging
   - Tests automatisés

3. **feature/**
   - Nouvelles fonctionnalités
   - Préfixe: `feature/`
   - Exemple: `feature/booking-system`

4. **bugfix/**
   - Corrections de bugs
   - Préfixe: `bugfix/`
   - Exemple: `bugfix/payment-validation`

5. **hotfix/**
   - Corrections urgentes
   - Préfixe: `hotfix/`
   - Exemple: `hotfix/security-patch`

## 3. Protection des Branches

### Configuration GitHub
```yaml
# main
- Require pull request reviews before merging
- Require status checks to pass before merging
- Require branches to be up to date before merging
- Include administrators
- Restrict who can push to matching branches

# develop
- Require pull request reviews before merging
- Require status checks to pass before merging
```

### Checks Obligatoires
- Tests unitaires
- Tests d'intégration
- Analyse statique (PHPStan, ESLint)
- Build réussie
- Couverture de tests minimale

## 4. Pull Requests

### Template de PR
```markdown
## Description
[Description détaillée des changements]

## Type de changement
- [ ] Nouvelle fonctionnalité
- [ ] Correction de bug
- [ ] Amélioration
- [ ] Refactoring
- [ ] Documentation

## Tests
- [ ] Tests unitaires ajoutés/modifiés
- [ ] Tests d'intégration ajoutés/modifiés
- [ ] Tests E2E ajoutés/modifiés

## Checklist
- [ ] Code conforme aux standards
- [ ] Documentation mise à jour
- [ ] Tests passants
- [ ] Revue de code effectuée

## Screenshots (si applicable)
[Captures d'écran des changements UI]
```

### Conventions de Commits
```
<type>(<scope>): <description>

[body]

[footer]
```

Types:
- feat: Nouvelle fonctionnalité
- fix: Correction de bug
- docs: Documentation
- style: Formatage
- refactor: Refactoring
- test: Tests
- chore: Maintenance

## 5. CI/CD avec GitHub Actions

### Workflows Principaux

```yaml
# .github/workflows/tests.yml
name: Tests

on:
  push:
    branches: [ main, develop ]
  pull_request:
    branches: [ main, develop ]

jobs:
  test:
    runs-on: ubuntu-latest
    services:
      mysql:
        image: mysql:5.7
        env:
          MYSQL_DATABASE: taxysoa_test
          MYSQL_ROOT_PASSWORD: root
        ports:
          - 3306:3306
        options: --health-cmd="mysqladmin ping" --health-interval=10s --health-timeout=5s --health-retries=3

    steps:
      - uses: actions/checkout@v2
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.1'
          extensions: mbstring, xml, ctype, iconv, intl, pdo_mysql
          coverage: xdebug
          
      - name: Setup Node.js
        uses: actions/setup-node@v2
        with:
          node-version: '16'
          
      - name: Install dependencies
        run: |
          composer install --prefer-dist --no-ansi --no-interaction --no-progress --no-scripts
          npm ci
          
      - name: Execute tests
        env:
          DB_CONNECTION: mysql
          DB_DATABASE: taxysoa_test
          DB_USERNAME: root
          DB_PASSWORD: root
        run: |
          php artisan test
          npm run test
```

```yaml
# .github/workflows/deploy.yml
name: Deploy

on:
  push:
    branches: [ main ]

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.1'
          
      - name: Install dependencies
        run: |
          composer install --prefer-dist --no-dev --no-ansi --no-interaction --no-progress --no-scripts
          npm ci
          npm run build
          
      - name: Deploy to production
        uses: appleboy/ssh-action@master
        with:
          host: ${{ secrets.SSH_HOST }}
          username: ${{ secrets.SSH_USERNAME }}
          key: ${{ secrets.SSH_PRIVATE_KEY }}
          script: |
            cd /var/www/taxysoa
            git pull origin main
            composer install --no-dev
            php artisan migrate --force
            php artisan optimize
            npm run build
```

## 6. Déploiement

### Environnements
1. **Développement (local)**
   - Branche: develop
   - URL: http://dev.taxysoa.com
   - Base de données: taxysoa_dev

2. **Staging**
   - Branche: develop
   - URL: http://staging.taxysoa.com
   - Base de données: taxysoa_staging

3. **Production**
   - Branche: main
   - URL: https://taxysoa.com
   - Base de données: taxysoa_prod

### Stratégie de Déploiement
1. **Zero-Downtime**
   - Blue-Green Deployment
   - Load Balancer
   - Health Checks

2. **Rollback**
   - Snapshots de base de données
   - Tags Git
   - Scripts de rollback

### Gestion des Secrets
```bash
# Production
- Variables d'environnement chiffrées
- Secrets GitHub
- Vault ou équivalent
- Rotation régulière des clés
```

## 7. Monitoring et Alerts

### Métriques à Surveiller
- Performance de l'application
- Taux d'erreur
- Temps de réponse
- Utilisation des ressources

### Alertes
- Slack/Email notifications
- PagerDuty pour les incidents critiques
- Tableau de bord Grafana 