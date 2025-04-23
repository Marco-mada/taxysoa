# Stratégie de Tests - TaxySoa

## 1. Types de Tests

### Backend (Laravel)

#### Tests Unitaires
- **Modèles Eloquent**
  - Relations
  - Accesseurs/Mutateurs
  - Scopes
  - Validation des attributs

```php
// Exemple de test de modèle
public function test_booking_has_driver_relation()
{
    $booking = Booking::factory()->create();
    $this->assertInstanceOf(Driver::class, $booking->driver);
}
```

#### Tests d'API
- **Contrôleurs**
  - Routes
  - Validation des requêtes
  - Réponses HTTP
  - Middleware

```php
// Exemple de test d'API
public function test_can_create_booking()
{
    $user = User::factory()->create();
    $response = $this->actingAs($user)
        ->postJson('/api/bookings', [
            'pickup_location' => 'Antananarivo',
            'destination' => 'Toamasina',
            'vehicle_type' => 'standard'
        ]);
    
    $response->assertStatus(201)
        ->assertJsonStructure([
            'data' => [
                'id',
                'pickup_location',
                'destination',
                'status'
            ]
        ]);
}
```

#### Tests d'Intégration
- **Services**
  - Calcul de prix
  - Géolocalisation
  - Paiements
  - Notifications

### Frontend (Vue.js)

#### Tests Unitaires (Jest)
- **Composants**
  - Props
  - Événements
  - Slots
  - Computed properties

```javascript
// Exemple de test de composant
test('renders booking form correctly', () => {
    const wrapper = mount(BookingForm)
    expect(wrapper.find('.pickup-input').exists()).toBe(true)
    expect(wrapper.find('.destination-input').exists()).toBe(true)
})
```

#### Tests de Composabilité
- **Stores (Pinia)**
  - Actions
  - Getters
  - Mutations
  - État

#### Tests E2E (Cypress)
- **Flux utilisateur**
  - Réservation
  - Paiement
  - Navigation
  - Authentification

```javascript
// Exemple de test E2E
describe('Booking Flow', () => {
    it('completes a booking successfully', () => {
        cy.visit('/book')
        cy.get('.pickup-input').type('Antananarivo')
        cy.get('.destination-input').type('Toamasina')
        cy.get('.submit-button').click()
        cy.url().should('include', '/booking/confirmation')
    })
})
```

## 2. Objectifs de Couverture

### Backend
- Modèles: 90%
- Contrôleurs: 85%
- Services: 80%
- Middleware: 75%

### Frontend
- Composants: 85%
- Stores: 80%
- Utils: 90%
- Tests E2E: 70%

## 3. Environnements de Test

### Configuration
```php
// phpunit.xml
<php>
    <env name="APP_ENV" value="testing"/>
    <env name="DB_CONNECTION" value="sqlite"/>
    <env name="DB_DATABASE" value=":memory:"/>
    <env name="CACHE_DRIVER" value="array"/>
    <env name="QUEUE_CONNECTION" value="sync"/>
</php>
```

### Données de Test
```php
// database/factories
class BookingFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'driver_id' => Driver::factory(),
            'pickup_location' => $this->faker->address,
            'destination' => $this->faker->address,
            'status' => 'pending',
            'price' => $this->faker->numberBetween(10000, 50000),
        ];
    }
}
```

## 4. Intégration dans le Workflow

### Git Hooks
```bash
# .git/hooks/pre-commit
#!/bin/sh
php artisan test
npm run test:unit
```

### CI/CD (GitHub Actions)
```yaml
# .github/workflows/tests.yml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
      - name: Setup Node.js
        uses: actions/setup-node@v2
      - name: Install dependencies
        run: |
          composer install
          npm install
      - name: Run tests
        run: |
          php artisan test
          npm run test
```

## 5. Conventions de Test

### Nommage
- `test_[scenario]_[expected_result]`
- `test_[method]_[condition]`
- `test_[feature]_[behavior]`

### Organisation
```
tests/
├── Unit/
│   ├── Models/
│   ├── Services/
│   └── Utils/
├── Feature/
│   ├── Api/
│   ├── Auth/
│   └── Booking/
└── Browser/
    ├── Auth/
    ├── Booking/
    └── Payment/
```

### Documentation
```php
/**
 * @test
 * @group booking
 * @group api
 * @description Vérifie qu'une réservation peut être créée avec des données valides
 */
public function test_can_create_booking()
{
    // ...
}
```

## 6. Outils Recommandés

### Backend
- PHPUnit
- Laravel Dusk
- Mockery
- Faker

### Frontend
- Jest
- Vue Test Utils
- Cypress
- MSW (Mock Service Worker)

### Qualité de Code
- PHPStan
- ESLint
- Prettier
- SonarQube

## 7. Bonnes Pratiques

1. **Tests Unitaires**
   - Un test = une assertion
   - Utiliser des données de test réalistes
   - Isoler les dépendances

2. **Tests d'Intégration**
   - Tester les cas d'erreur
   - Vérifier les effets de bord
   - Nettoyer après les tests

3. **Tests E2E**
   - Tester les flux critiques
   - Simuler les interactions utilisateur
   - Vérifier les performances

4. **Maintenance**
   - Mettre à jour les tests avec le code
   - Documenter les changements
   - Automatiser l'exécution 