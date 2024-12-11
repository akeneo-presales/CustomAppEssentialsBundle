<?php

namespace AkeneoPresales\CustomAppEssentialsBundle\Service;

use Behat\Transliterator\Transliterator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;

class GetTenantService
{
    private EntityRepository $tenantRepository;

    public function __construct(string $tenantClass, EntityManagerInterface $entityManager)
    {
        $this->tenantRepository = $entityManager->getRepository($tenantClass);
    }
    public function getTenantShort(Request $request)
    {
        $session = $request->getSession();
        $pimUrl = $session->get('pim_url');

        if (empty($pimUrl)) {
            return new \LogicException('Can\'t retrieve PIM url, please restart the authorization process.');
        }
        return Transliterator::transliterate(
            substr($pimUrl, strpos($pimUrl, '//')+2, strpos($pimUrl, '.')-(strpos($pimUrl, '//')+2)),'_'
        );
    }

    public function getTenant(Request $request)
    {
        $session = $request->getSession();
        $pimUrl = $session->get('pim_url');

        if (empty($pimUrl)) {
            throw new \LogicException('Can\'t retrieve PIM url, please restart the authorization process.');
        }

        return $this->tenantRepository->findOneBy(['domainName' => str_replace(['https://', 'http://'], '', $pimUrl)]);
    }

    public function getTenantByUrl(string $pimURL)
    {
        return $this->tenantRepository->findOneBy(['domainName' => str_replace(['https://', 'http://'], '', $pimURL)]);
    }

}
