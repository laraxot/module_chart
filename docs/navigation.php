<?php

declare(strict_types=1);

return [
    'Introduzione al modulo '.$moduleName => [
        'url' => 'docs/introduzione',
        'children' => [
            // 'Introducendo '.$moduleName => [
            //     'url' => 'docs/introduzione',
            // ],
            /*'Crediti' => [
                'url' => 'docs/crediti',
            ],*/
            'Installazione' => [
                'url' => 'docs/installazione',
            ],
            /*$moduleName.' Starter Kit' => [
                'url' => 'docs/starter-kit',
            ],*/
            'Aggiornamenti' => [
                'url' => 'docs/aggiornamenti',
            ],
            /*'Tabella di Marcia' => [
                'url' => 'docs/tabella-di-marcia',
            ],
            'Comparazioni' => [
                'url' => 'docs/comparazioni',
            ],*/
        ],
    ],
    'Metodi Principali' => [
        'url' => '#',
        'children' => [
            // 'Funzionalità 1' => [
            //     'url' => 'docs/methods/',
            // ],
            // 'Funzionalità 2' => [
            //     'url' => 'docs/methods/',
            // ],
        ],
    ],
    'Componenti' => [
        'url' => '#',
        'children' => [
            'Chartjs' => [
                'url' => '#',
                'children' => [
                    'Base' => [
                        'url' => 'docs/components/chartjs/base',
                    ],
                ],
            ],
            'Graph' => [
                'url' => 'docs/components/graph',
            ],
        ],
        // 'Componenti 2' => [
        //     'url' => 'docs/components/',
        // ],
    ],

    'Caratteristiche Avanzate' => [
        'url' => '#',
        'children' => [
            'Echarts' => [
                'url' => 'docs/advanced/echarts',
            ],
            // 'Caratteristiche Avanzate 2' => [
            //     'url' => 'docs/advanced/',
            // ],
        ],
    ],
];
