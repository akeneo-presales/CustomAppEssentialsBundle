<?php

namespace AkeneoPresales\CustomAppEssentialsBundle\Service;

use AkeneoPresales\CustomAppEssentialsBundle\Entity\TenantInterface;
use AkeneoPresales\CustomAppEssentialsBundle\Entity\Transformer\UIExtensionTransformer;
use AkeneoPresales\CustomAppEssentialsBundle\Entity\UIExtension;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class AkeneoUIExtensionService
{
    private $client;
    private $targetPimUrl;

    private function setClient(TenantInterface $tenant)
    {
        $this->targetPimUrl = 'https://' . $tenant->getDomainName();
        $pimApiToken = $tenant->getAccessToken();

        $this->client = new Client([
            'base_uri' => $this->targetPimUrl,
            'headers' => [
                'Authorization' => 'Bearer ' . $pimApiToken,
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function listExtensions(TenantInterface $tenant): ?array
    {
        $this->setClient($tenant);

        try {
            $response = $this->client->get('/api/rest/v1/ui-extensions');
            return json_decode($response->getBody()->getContents(), true); // Returns list of extensions
        } catch (RequestException $e) {
            // Handle exceptions, e.g., log errors or return specific messages
            return null;
        }
    }

    public function getExtension(TenantInterface $tenant, string $uiExtensionUuid)
    {
        $extensions = $this->listExtensions($tenant);

        foreach ($extensions as $extension) {
            if ($extension['uuid'] === $uiExtensionUuid) {
                return UIExtensionTransformer::apiResultToObject($extension);
            }
        }
    }

    public function upsertExtension(TenantInterface $tenant, UIExtension $extension): ?string
    {
        $this->setClient($tenant);

        $method = null === $extension->getUuid() ? 'post' : 'patch';
        $url = null === $extension->getUuid() ? "/api/rest/v1/ui-extensions" : "/api/rest/v1/ui-extensions/" . $extension->getUuid();

        try {
            $response = $this->client->{$method}($url, [
                'json' => UIExtensionTransformer::objectToApiResult($extension),
            ]);
        } catch (RequestException $e) {
            if ($e->getCode() === 422) {
                // Handle validation errors, e.g., log them or return a specific message
                $jsonResponse = json_decode($e->getResponse()->getBody()->getContents(), true);
                $message = '';
                foreach ($jsonResponse['errors'] as $error) {
                    $message .= $error['property'] . ' : ' . $error['message']. "\n";
                }
                throw new \Exception('Validation failed : ' . $message);
            }
        }

        $statusCode = $response->getStatusCode();
        if ($statusCode === 201) {
            return 'created'; // Extension created
        } elseif ($statusCode === 204) {
            return 'updated'; // Extension updated
        }

        return null;
    }

    public function deleteExtension(TenantInterface $tenant, string $uiExtensionUuid): bool
    {
        $this->setClient($tenant);

        try {
            $this->client->delete("/api/rest/v1/ui-extensions/$uiExtensionUuid");
            return true; // Successfully deleted
        } catch (RequestException $e) {
            // Handle exceptions, e.g., log errors or return specific messages
            return false;
        }
    }
}
