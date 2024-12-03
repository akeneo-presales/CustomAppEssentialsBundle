<?php

namespace AkeneoPresales\CustomAppEssentialsBundle\Controller;

use AkeneoPresales\CustomAppEssentialsBundle\Service\AkeneoEventPlatformService;
use AkeneoPresales\CustomAppEssentialsBundle\Service\GetTenantService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EventPlatformDeleteSubscribtionAction extends AbstractController
{
    #[Route('/event-platform/subscriber/{subscriber_id}/subscribtion/{id}/delete', name: 'akeneo_presales_custom_app_essentials_event-platform-delete-subscription', methods: ['POST'])]
    public function __invoke($subscriber_id, $id, Request $request, GetTenantService $getTenantService,)
    {
        $tenant = $getTenantService->getTenant($request);

        $akeneoEventPlatformService = new AkeneoEventPlatformService();

        $subscription = $akeneoEventPlatformService->getSubscription($tenant, $subscriber_id, $id);

        $akeneoEventPlatformService->deleteSubscription($tenant, $subscriber_id, $id);

        $this->addFlash('success', 'Subscription deleted with success.');

        return $this->redirectToRoute('akeneo_presales_custom_app_essentials_event_platform_configuration');

    }

}
