<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('idci_graphql_client', [
        'clients' => [
            'akeneo_pim' => [
                'http_client' => 'eight_points_guzzle.client.akeneo_pim',
            ],
        ],
    ]);
};
