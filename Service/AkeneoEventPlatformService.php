<?php
namespace AkeneoPresales\CustomAppEssentialsBundle\Service;

use AkeneoPresales\CustomAppEssentialsBundle\Entity\TenantInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class AkeneoEventPlatformService
{
    private $client;
    private $targetPimUrl;

    private function setClient(TenantInterface $tenant)
    {
        $this->targetPimUrl = 'https://' . $tenant->getDomainName();
        $clientId = $tenant->getClientId();
        $pimApiToken = $tenant->getAccessToken();

        $this->client = new Client([
            'base_uri' => 'https://event.prd.sdk.akeneo.cloud',
            'headers' => [
                'X-PIM-URL' => $this->targetPimUrl,
                'X-PIM-TOKEN' => $pimApiToken,
                'X-PIM-CLIENT-ID' => $clientId,
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function createSubscriber(TenantInterface $tenant, $name, string $technicalEmail)
    {
        $this->setClient($tenant);

        try {
            $response = $this->client->post('/api/v1/subscribers', [
                'json' => [
                    'name' => $name,
                    'contact' => [
                        'technical_email' => $technicalEmail,
                    ],
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            return $data['id'] ?? null; // Return subscriber ID
        } catch (RequestException $e) {
            // Handle exceptions, e.g., log errors or return specific messages
            return null;
        }
    }

    public function deleteSubscriber(TenantInterface $tenant, $subscriberId): bool
    {
        $this->setClient($tenant);

        try {
            $this->client->delete("/api/v1/subscribers/$subscriberId");
            return true; // Return true if deletion was successful
        } catch (RequestException $e) {
            return false;
        }
    }

    public function createSubscription(
        TenantInterface $tenant,
        string $subscriberId,
        array  $eventTypes,
        string $subscriptionType = 'https',
        array  $config = []
    )
    {
        $this->setClient($tenant);

        $payload = $this->buildSubscriptionPayload($eventTypes, $subscriptionType, $config);

        $response = $this->client->post("/api/v1/subscribers/$subscriberId/subscriptions", [
            'json' => $payload,
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        return $data['id'] ?? null; // Return subscription ID
    }

    public function updateSubscription(
        TenantInterface $tenant,
        string $subscriberId,
        string $subscriptionId,
        array  $eventTypes,
        string $subscriptionType = 'https',
        array  $config = []
    )
    {
        $this->setClient($tenant);
        $payload = $this->buildSubscriptionPayload($eventTypes, $subscriptionType, $config);

        $response = $this->client->patch("/api/v1/subscribers/$subscriberId/subscriptions/$subscriptionId", [
            'json' => $payload,
        ]);
        $data = json_decode($response->getBody()->getContents(), true);
        return $data; // Return updated subscription data

    }

    public function listSubscriptions(TenantInterface $tenant, $subscriberId)
    {
        $this->setClient($tenant);
        try {
            $response = $this->client->get("/api/v1/subscribers/$subscriberId/subscriptions");

            $data = json_decode($response->getBody()->getContents(), true);
            return $data; // Return the list of subscriptions
        } catch (RequestException $e) {
            // Handle exceptions, e.g., log errors or return specific messages
            return null;
        }
    }

    public function listSubscribers(TenantInterface $tenant)
    {
        $this->setClient($tenant);
        try {
            $response = $this->client->get('/api/v1/subscribers');

            $data = json_decode($response->getBody()->getContents(), true);
            return $data; // Return the list of subscribers
        } catch (RequestException $e) {
            return null;
        }
    }

    public function getSubscription(TenantInterface $tenant, $subscriberId, string $subscriptionId)
    {
        $this->setClient($tenant);

        try {
            $response = $this->client->get("/api/v1/subscribers/$subscriberId/subscriptions/$subscriptionId");

            $data = json_decode($response->getBody()->getContents(), true);
            return $data; // Return the subscription details
        } catch (RequestException $e) {
            return null;
        }
    }

    public function deleteSubscription(TenantInterface $tenant, $subscriberId, string $subscriptionId): bool
    {
        $this->setClient($tenant);

        try {
            $this->client->delete("/api/v1/subscribers/$subscriberId/subscriptions/$subscriptionId");
            return true; // Return true if deletion was successful
        } catch (RequestException $e) {
            return false;
        }
    }


    private function buildSubscriptionPayload(array $eventTypes, string $subscriptionType, array $config): \stdClass
    {
        $payload = new \stdClass();

        $payload->source = 'pim';
        $payload->subject = $this->targetPimUrl;
        $payload->events = array_values($eventTypes);
        $payload->type = $subscriptionType;

        if ($subscriptionType === 'https') {
            $configObj = new \stdClass();

            $configObj->url = $config['url'] ?? '';
            $configObj->secret = $config['secret'];
            $payload->config = $configObj;
        } elseif ($subscriptionType === 'pubsub') {
            $configObj = new \stdClass();

            $configObj->project_id = $config['project_id'] ?? '';
            $configObj->topic_id = $config['topic_id'] ?? '';

            $payload->config = $configObj;
        }

        return $payload;
    }
}
