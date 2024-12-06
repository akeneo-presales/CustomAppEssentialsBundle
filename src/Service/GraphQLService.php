<?php

namespace AkeneoPresales\CustomAppEssentialsBundle\Service;

use AkeneoPresales\CustomAppEssentialsBundle\Entity\TenantInterface;
use IDCI\Bundle\GraphQLClientBundle\Client\GraphQLApiClientInterface;
use IDCI\Bundle\GraphQLClientBundle\Client\GraphQLApiClientRegistryInterface;
use IDCI\Bundle\GraphQLClientBundle\Query\GraphQLQuery;

class GraphQLService
{
    private GraphQLApiClientInterface $client;

    public function __construct(GraphQLApiClientRegistryInterface $graphQlApiClientRegistry)
    {
        $this->client = $graphQlApiClientRegistry->get('akeneo_pim');
    }

    public function getProduct(TenantInterface $tenant, string $uuid, array $attributes = ['sku'], string $locale = 'en_US', string $scope = 'ecommerce')
    {
        $qb = $this->client->createQueryBuilder();

        $items = [
            'attributes' => [
                'code',
                'labels',
                'sortOrder',
                'type',
                'group' => [
                    'code',
                    'labels',
                    'sortOrder',
                ],
                'values' => [
                    '_parameters' => [
                        'withRelatedObjectValues' => true,
                    ],
                ],
            ],
            'family' => [
                'code',
                'labels',
            ],
            'categories' => [
                'code',
                'labels',
            ],
            'uuid',
            'variationValues',
        ];

        foreach ($attributes as $attribute) {
            $items[$attribute] = ['_alias' => sprintf('attributeValues(code: "%s")', $attribute)];
        }

        $qb
            ->setType(GraphQLQuery::QUERY_TYPE)
            ->setAction('products')
            ->addArgument('uuid', $uuid)
            ->addArgument('limit', 1)
            ->addArgument('locales', $locale)
            ->addArgument('attributesToLoad', $attributes)
            ->addRequestedField('items', $items);

        $query = $qb->getQuery();

        $this->addAuthHeaderstoQuery($query, $tenant);

        $result = $query->getResults();

        return $result['items'][0] ?? null;
    }

    public function listProducts(TenantInterface $tenant, array $attributes = ['sku'], $limit = 10, string $locale = 'en_US')
    {
        $qb = $this->client->createQueryBuilder();

        $items = [
            'attributes' => [
                'code',
                'labels',
                'sortOrder',
                'type',
                'group' => [
                    'code',
                    'labels',
                    'sortOrder',
                ],
                'values' => [
                    '_parameters' => [
                        'withRelatedObjectValues' => true,
                    ],
                ],
            ],
            'family' => [
                'code',
                'labels',
            ],
            'categories' => [
                'code',
                'labels',
            ],
            'uuid',
            'variationValues',
        ];

        foreach ($attributes as $attribute) {
            $items[$attribute] = ['_alias' => sprintf('attributeValues(code: "%s")', $attribute)];
        }

        $qb
            ->setType(GraphQLQuery::QUERY_TYPE)
            ->setAction('products')
            ->addArgument('limit', $limit)
            ->addArgument('locales', $locale)
            ->addArgument('attributesToLoad', $attributes)
            ->addRequestedField('items', $items);

        $query = $qb->getQuery();

        $this->addAuthHeaderstoQuery($query, $tenant);

// for debugging purpose
        $graphQlQuery = $query->getGraphQLQuery();
// for debugging purpose
        $headers = json_encode($query->getHeaders());

        $result = $query->getResults();

        return $result['items'] ?? null;
    }

    private function addAuthHeaderstoQuery(GraphQLQuery &$query, TenantInterface $tenant)
    {
        $query->addHeader('X-PIM-URL', 'https://' . $tenant->getDomainName());
        $query->addHeader('X-PIM-CLIENT-ID', $tenant->getClientId());
        $query->addHeader('X-PIM-TOKEN', $tenant->getAccessToken());
    }
}
