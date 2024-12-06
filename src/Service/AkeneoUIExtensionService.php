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
            $response = $this->client->get('/api/rest/v1/ui-extension');
            return json_decode($response->getBody()->getContents(), true); // Returns list of extensions
        } catch (RequestException $e) {
            // Handle exceptions, e.g., log errors or return specific messages
            return null;
        }
    }

    public function getExtension(TenantInterface $tenant, string $uiExtensionCode)
    {
        $extensions = $this->listExtensions($tenant);

        foreach ($extensions as $extension) {
            if ($extension['code'] === $uiExtensionCode) {
                return UIExtensionTransformer::apiResultToObject($extension);
            }
        }
    }

    public function upsertExtension(TenantInterface $tenant, UIExtension $extension): ?string
    {
        $this->setClient($tenant);

        $response = $this->client->post("/api/rest/v1/ui-extension/" . $extension->getCode(), [
            'json' => UIExtensionTransformer::objectToApiResult($extension),
        ]);

        $statusCode = $response->getStatusCode();
        if ($statusCode === 201) {
            return 'created'; // Extension created
        } elseif ($statusCode === 204) {
            return 'updated'; // Extension updated
        }

        return null;
    }

    public function deleteExtension(TenantInterface $tenant, string $uiExtensionCode): bool
    {
        $this->setClient($tenant);

        try {
            $this->client->delete("/api/rest/v1/ui-extension/$uiExtensionCode");
            return true; // Successfully deleted
        } catch (RequestException $e) {
            // Handle exceptions, e.g., log errors or return specific messages
            return false;
        }
    }
}
