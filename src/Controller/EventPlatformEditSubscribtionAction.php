<?php

namespace AkeneoPresales\CustomAppEssentialsBundle\Controller;

use AkeneoPresales\CustomAppEssentialsBundle\Entity\Subscription;
use AkeneoPresales\CustomAppEssentialsBundle\Form\Type\SubscriptionType;
use AkeneoPresales\CustomAppEssentialsBundle\Service\AkeneoEventPlatformService;
use AkeneoPresales\CustomAppEssentialsBundle\Service\GetTenantService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EventPlatformEditSubscribtionAction extends AbstractController
{
    #[Route('/event-platform/subscriber/{subscriber_id}/subscribtion/{id}/edit', name: 'akeneo_presales_custom_app_essentials_event-platform-edit-subscription', methods: ['GET', 'POST'])]
    public function __invoke($subscriber_id, $id, Request $request,  GetTenantService $getTenantService,)
    {
        $tenant = $getTenantService->getTenant($request);

        $akeneoEventPlatformService = new AkeneoEventPlatformService();

        $subscription = $akeneoEventPlatformService->getSubscription($tenant, $subscriber_id, $id);

        $subObj = (new Subscription())->setEvents($subscription['events'])->setType($subscription['type'])->setId($subscription['id'])->setConfig($subscription['config']);

        $form = $this->createForm(SubscriptionType::class, $subObj,  ['subscription_form_type' => $subObj->getType()]);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            try {
                $akeneoEventPlatformService->updateSubscription($tenant, $subscriber_id, $id, $subObj->getEvents(),$subObj->getType(), $subObj->getConfig());
                $this->addFlash('success', 'Subscription updated successfully.');
            } catch (\Exception $e) {
                $this->addFlash('error', $e->getMessage());
            }
            return $this->redirectToRoute('akeneo_presales_custom_app_essentials_event_platform_configuration');
        }

        return $this->json(['result' => $this->renderView('@AkeneoPresalesCustomAppEssentials/eventPlatform/editSubscriptionForm.html.twig', [
            'id' => $id,
            'url' => $this->generateUrl('akeneo_presales_custom_app_essentials_event-platform-edit-subscription', ['subscriber_id' => $subscriber_id, 'id' => $id]),
            'subscriberId' => $subscriber_id,
            'form' => $form->createView(),
        ])]);
    }

}
