<?php

namespace AkeneoPresales\CustomAppEssentialsBundle\Service;

use AkeneoPresales\CustomAppEssentialsBundle\Entity\TenantInterface;
use AkeneoPresales\CustomAppEssentialsBundle\PimApi\PimApiClientFromTenantFactory;
use App\Exception\MissingPimApiAccessTokenException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\UnencryptedToken;
use Lcobucci\JWT\Validation\Constraint\IssuedBy;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TenantService
{
    private EntityRepository $tenantRepository;

    public function __construct(string                        $tenantClass,
                                private readonly EntityManagerInterface        $entityManager,
                                private readonly HttpClientInterface           $client,
                                private readonly PimApiClientFromTenantFactory $pimApiClientFromTenantFactory,
    )
    {
        $this->tenantRepository = $this->entityManager->getRepository($tenantClass);
    }
    public function fetchAccessTokenPayload(mixed $pimUrl, float|bool|int|string $authorizationCode): array
    {
        /** @var TenantInterface $tenant */
        $tenant = $this->tenantRepository->findOneBy(['domainName' => str_replace(['https://', 'http://'], '', $pimUrl)]);

        $codeIdentifier = \bin2hex(\random_bytes(30));
        $codeChallenge = \hash('sha256', $codeIdentifier.$tenant->getClientSecret());

        $accessTokenRequestPayload = [
            'grant_type' => 'authorization_code',
            'code' => $authorizationCode,
            'client_id' => $tenant->getClientId(),
            'code_identifier' => $codeIdentifier,
            'code_challenge' => $codeChallenge,
        ];

        $accessTokenUrl = $pimUrl.'/connect/apps/v1/oauth2/token';


            $response = $this->client->request('POST', $accessTokenUrl, [
                'headers' => [
                    'Content-type' => 'application/x-www-form-urlencoded',
                ],
                'body' => $accessTokenRequestPayload,
            ]);

            $content = $response->getContent();

        $payload = \json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        if (!\array_key_exists('access_token', $payload)) {
            throw new \LogicException('Missing access token in response');
        }

        $userProfile = null;
        $idToken = $payload['id_token'] ?? null;
        if (null !== $idToken) {
            $openIdPublicKey = $this->fetchOpenIdPublicKey($pimUrl);
            $claims = $this->extractClaimsFromSignedToken($idToken, $openIdPublicKey, $pimUrl);
            $userProfile = $this->getUserProfileFromTokenClaims($claims);
        }

        return [
            'access_token' => (string) $payload['access_token'],
            'user_profile' => $userProfile,
        ];
    }
    /**
     * @return array<string, mixed>
     */
    private function extractClaimsFromSignedToken(string $idToken, string $signature, string $issuer): array
    {
        $jwtConfig = Configuration::forUnsecuredSigner();
        $token = $jwtConfig->parser()->parse($idToken);
        \assert($token instanceof UnencryptedToken);

        $jwtConfig->setValidationConstraints(new IssuedBy($issuer), new SignedWith(new Sha256(), InMemory::plainText($signature)));
        $constraints = $jwtConfig->validationConstraints();
        $jwtConfig->validator()->assert($token, ...$constraints);

        return $token->claims()->all();
    }

    private function fetchOpenIdPublicKey(string $pimUrl): string
    {
        $openIDPublicKeyUrl = $pimUrl.'/connect/apps/v1/openid/public-key';

        $response = $this->client->request('GET', $openIDPublicKeyUrl)->toArray();
        if (!\array_key_exists('public_key', $response)) {
            throw new \LogicException('Failed to retrieve openid public key');
        }
        if (!\is_string($response['public_key'])) {
            throw new \LogicException('OpenID public key is not a string');
        }

        return $response['public_key'];
    }

    /**
     * @param array<string, mixed> $tokenClaims
     */
    private function getUserProfileFromTokenClaims(array $tokenClaims): array
    {
        if (!isset($tokenClaims['firstname'], $tokenClaims['lastname'], $tokenClaims['email'])) {
            throw new \LogicException('One or several user profile claims are missing');
        }

        return ['email' => $tokenClaims['email'], 'lastname' => $tokenClaims['lastname'], 'firstname' => $tokenClaims['firstname']];
    }

    public function updateAccessTokenForTenantPimUrl(mixed $pimUrl, $accessToken)
    {
        /** @var TenantInterface $tenant */
        $tenant = $this->tenantRepository->findOneBy(['domainName' => str_replace(['https://', 'http://'], '', $pimUrl)]);
        $tenant->setAccessToken($accessToken);
        $this->entityManager->flush();
    }

    public function checkConnection(TenantInterface $tenant)
    {
        try {
            $client = $this->pimApiClientFromTenantFactory->getClient($tenant);
            $client->getLocaleApi()->all();
            return true;
        }
        catch (MissingPimApiAccessTokenException $e) {
            return true;
        }
        catch (\Exception $e) {
            return false;
        }
    }
}
