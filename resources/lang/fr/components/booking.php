<?php

return [
    'steps' => [
        'pickup' => [
            'title' => 'Point de départ',
            'placeholder' => 'Entrez votre adresse de départ',
            'current_location' => 'Utiliser ma position actuelle',
        ],
        'destination' => [
            'title' => 'Destination',
            'placeholder' => 'Entrez votre destination',
        ],
        'vehicle' => [
            'title' => 'Type de véhicule',
            'standard' => 'Standard',
            'comfort' => 'Confort',
            'premium' => 'Premium',
            'capacity' => 'Capacité : :passengers passagers',
        ],
        'payment' => [
            'title' => 'Paiement',
            'estimated_price' => 'Prix estimé',
            'payment_method' => 'Méthode de paiement',
            'cash' => 'Espèces',
            'card' => 'Carte bancaire',
            'mobile' => 'Paiement mobile',
        ],
    ],
    'status' => [
        'searching' => 'Recherche de chauffeur...',
        'driver_found' => 'Chauffeur trouvé !',
        'arriving' => 'Le chauffeur arrive dans :minutes minutes',
        'in_progress' => 'Course en cours',
        'completed' => 'Course terminée',
    ],
    'actions' => [
        'book' => 'Réserver',
        'cancel' => 'Annuler',
        'contact' => 'Contacter le chauffeur',
        'rate' => 'Noter la course',
    ],
    'messages' => [
        'no_drivers' => 'Aucun chauffeur disponible pour le moment',
        'confirm_cancel' => 'Êtes-vous sûr de vouloir annuler cette course ?',
        'success' => 'Votre course a été réservée avec succès',
        'error' => 'Une erreur est survenue lors de la réservation',
    ],
]; 