<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('eight_points_guzzle', [
        'clients' => [
            'akeneo_pim' => [
                'base_url' => 'https://graphql.sdk.akeneo.cloud/',
                'options' => [
                    'timeout' => 30,
                    'http_errors' => true,
                    'headers' => [
                        'User-Agent' => 'DemoToolkit GraphQL Agent',
                    ],
                ],
                'plugin' => null,
            ],
        ],
    ]);
};
