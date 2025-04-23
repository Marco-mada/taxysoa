<?php

return [
    'default' => 'MGA',
    'currencies' => [
        'MGA' => [
            'name' => 'Ariary malgache',
            'symbol' => 'Ar',
            'format' => ':amount Ar',
            'decimals' => 0,
            'thousands_separator' => ' ',
            'decimal_separator' => ',',
        ],
        'EUR' => [
            'name' => 'Euro',
            'symbol' => '€',
            'format' => ':amount €',
            'decimals' => 2,
            'thousands_separator' => ' ',
            'decimal_separator' => ',',
        ],
        'USD' => [
            'name' => 'Dollar américain',
            'symbol' => '$',
            'format' => '$:amount',
            'decimals' => 2,
            'thousands_separator' => ',',
            'decimal_separator' => '.',
        ],
    ],
]; 