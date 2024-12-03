<?php

namespace AkeneoPresales\CustomAppEssentialsBundle\Controller;

use AkeneoPresales\CustomAppEssentialsBundle\Service\AkeneoEventPlatformService;
use AkeneoPresales\CustomAppEssentialsBundle\Service\GetTenantService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventPlatflormConfigurationAction extends AbstractController
{
    #[Route('/event-platform/configuration', name: 'akeneo_presales_custom_app_essentials_event_platform_configuration', methods: ['GET', 'POST'])]
    public function __invoke(Request $request, GetTenantService $getTenantService, EntityManagerInterface $entityManager): Response
    {
        $tenant = $getTenantService->getTenant($request);

        $akeneoEventPlatformService = new AkeneoEventPlatformService();

        $subscribers = $akeneoEventPlatformService->listSubscribers($tenant);

        return new Response($this->renderView('@AkeneoPresalesCustomAppEssentials/eventPlatform/eventPlatformConfiguration.html.twig', [
            'subscribers' => $subscribers,
            'contextual_nav' => 'secondary-nav-config',
        ]));
    }
}
