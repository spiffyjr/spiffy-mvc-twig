<?php

return [
    'mvc' => [
        'plugins' => ['Spiffy\Mvc\Twig\TwigExtensionLoader'],
        'view_manager' => ['default_strategy' => 'spiffy.view.twig-strategy'],
    ],
    'mvc.twig' => [
        'suffix' => '.twig',
        'loader_paths' => ['mvc.twig' => __DIR__ . '/../view'],
        'options' => [
            'cache' => (isset($_ENV['debug']) && $_ENV['debug']) ? null : 'cache/twig',
            'debug' => isset($_ENV['debug']) ? $_ENV['debug'] : false,
        ]
    ]
];
