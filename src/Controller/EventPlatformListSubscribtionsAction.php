<?php

namespace AkeneoPresales\CustomAppEssentialsBundle\Controller;

use AkeneoPresales\CustomAppEssentialsBundle\Service\AkeneoEventPlatformService;
use AkeneoPresales\CustomAppEssentialsBundle\Service\GetTenantService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EventPlatformListSubscribtionsAction extends AbstractController
{
    #[Route('/event-platform/subscriber/{id}/list-subscriptions', name: 'akeneo_presales_custom_app_essentials_event-platform-list-subscriptions', methods: ['GET'])]
    public function __invoke($id, Request $request,  GetTenantService $getTenantService,)
    {

        $tenant = $getTenantService->getTenant($request);

        $akeneoEventPlatformService = new AkeneoEventPlatformService();

        $subscriptions = $akeneoEventPlatformService->listSubscriptions($tenant, $id);

        return $this->json(['result' => $this->renderView('@AkeneoPresalesCustomAppEssentials/eventPlatform/subscriptions.html.twig', [
            'subscriptions' => $subscriptions,
            'subscriberId' => $id
        ])]);
    }

}
