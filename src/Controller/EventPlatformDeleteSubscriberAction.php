<?php

namespace AkeneoPresales\CustomAppEssentialsBundle\Controller;

use AkeneoPresales\CustomAppEssentialsBundle\Service\GetTenantService;
use AkeneoPresales\CustomAppEssentialsBundle\Service\AkeneoEventPlatformService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EventPlatformDeleteSubscriberAction extends AbstractController
{
    #[Route('/event-platform/subscriber/{id}/delete', name: 'akeneo_presales_custom_app_essentials_event-platform-delete-subscriber', methods: ['POST'])]
    public function __invoke( $id, Request $request, GetTenantService $getTenantService,)
    {
        $tenant = $getTenantService->getTenant($request);

        $akeneoEventPlatformService = new AkeneoEventPlatformService();

        $akeneoEventPlatformService->deleteSubscriber($tenant, $id);

        $this->addFlash('success', 'Subscriber deleted with success.');

        return $this->redirectToRoute('akeneo_presales_custom_app_essentials_event_platform_configuration');

    }

}
