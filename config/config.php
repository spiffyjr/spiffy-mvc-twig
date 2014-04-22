<?php

return [
    'spiffy.mvc' => [
        'plugins' => [
            'Spiffy\Mvc\Twig\TwigExtensionLoader'
        ],
        'services' => [
            'Spiffy\\View\\TwigStrategy' => 'Spiffy\\Mvc\\Twig\\TwigStrategyFactory',
            'Twig_Environment' => 'Spiffy\\Mvc\\Twig\\TwigEnvironmentFactory',
        ],
        'view_manager' => [
            'default_strategy' => 'Spiffy\\View\\TwigStrategy',
        ],
    ],
    'spiffy.mvc.twig' => [
        'suffix' => '.twig',
        'loader_paths' => [
            'spiffy.mvc.twig' => __DIR__ . '/../view'
        ],
        'options' => [
            'cache' => isset($_ENV['debug']) && $_ENV['debug'] ? null : 'cache',
            'debug' => isset($_ENV['debug']) ? $_ENV['debug'] : false,
        ]
    ]
];
