<?php
// Retorna l'array associatiu d'usuaris i productes
return [
    'usuaris' => [
        [
            'email' => 'alumne@lacetania.cat',
            'nom' => 'Alumne DAW',
            // Hash de 'daw2026'
            'contrasenya' => '$2y$10$wT8KsqF5b6j2U/290E76kug79R0X4lG1E5Jc.15uTshY5W8qW7y8.',
            'rol' => 'alumne'
        ],
        [
            'email' => 'cantina@lacetania.cat',
            'nom' => 'Cantina',
            // Hash de 'cafe2026'
            'contrasenya' => '$2y$10$aK5vE5J792Uu7pE4y5W8qeE15uTshY5W8qW7y8.wT8KsqF5b6j2U',
            'rol' => 'admin'
        ]
    ],
    'productes' => [
        1 => ['nom' => 'Entrepà de pernil', 'preu' => 3.50],
        2 => ['nom' => 'Entrepà vegetal',   'preu' => 3.20],
        3 => ['nom' => 'Croissant',         'preu' => 1.40],
        4 => ['nom' => 'Suc de taronja',    'preu' => 1.80],
        5 => ['nom' => 'Cafè amb llet',     'preu' => 1.30],
        6 => ['nom' => 'Aigua',             'preu' => 1.00]
    ]
];