<?php

declare(strict_types=1);

namespace AkeneoPresales\CustomAppEssentialsBundle\PimApi;

use AkeneoPresales\CustomAppEssentialsBundle\Entity\TenantInterface;
use Akeneo\Pim\ApiClient\AkeneoPimClientBuilder;
use Akeneo\Pim\ApiClient\AkeneoPimClientInterface;
use App\Exception\MissingPimApiAccessTokenException;
use App\Exception\MissingPimUrlException;

class PimApiClientFromTenantFactory
{
    public function getClient(TenantInterface $tenant): AkeneoPimClientInterface
    {
        $pimURL = 'https://'.$tenant->getDomainName();
        if (empty($pimURL)) {
            throw new MissingPimUrlException();
        }

        $accessToken = $tenant->getAccessToken();
        if (empty($accessToken)) {
            throw new MissingPimApiAccessTokenException();
        }

        $clientBuilder = new AkeneoPimClientBuilder($pimURL);

        return $clientBuilder->buildAuthenticatedByAppToken($accessToken);
    }
}
