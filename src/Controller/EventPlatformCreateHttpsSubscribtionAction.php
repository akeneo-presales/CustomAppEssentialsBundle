<?php

namespace AkeneoPresales\CustomAppEssentialsBundle\Controller;

use AkeneoPresales\CustomAppEssentialsBundle\Entity\Subscription;
use AkeneoPresales\CustomAppEssentialsBundle\Form\Type\SubscriptionType;
use AkeneoPresales\CustomAppEssentialsBundle\Service\AkeneoEventPlatformService;
use AkeneoPresales\CustomAppEssentialsBundle\Service\GetTenantService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventPlatformCreateHttpsSubscribtionAction extends AbstractController
{
    #[Route('/event-platform/subscriber/{id}/create-https-subscription', name: 'akeneo_presales_custom_app_essentials_event-platform-create-https-subscription', methods: ['GET', 'POST'])]
    public function __invoke($id, Request $request,  GetTenantService $getTenantService,)
    {
        $tenant = $getTenantService->getTenant($request);

        $akeneoEventPlatformService = new AkeneoEventPlatformService();

        $subObj = new Subscription();
        $subObj->setType('https');
        $form = $this->createForm(SubscriptionType::class, $subObj, ['subscription_form_type' => $subObj->getType()]);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            try {
                $akeneoEventPlatformService->createSubscription($tenant, $id, $subObj->getEvents(), $subObj->getType(), $subObj->getConfig());
                // For AJAX, return a JSON success response
                $this->addFlash('success', 'HTTPS Subscription created successfully.');
                return $this->json(
                    ['success' => true, 'message' => 'HTTPS Subscription created successfully.'],
                    Response::HTTP_OK
                );
            } catch (\Exception $e) {
                return $this->json(
                    ['success' => false, 'message' => $e->getMessage()],
                    Response::HTTP_BAD_REQUEST
                );
            }
        }

        return $this->json(['result' => $this->renderView('@AkeneoPresalesCustomAppEssentials/eventPlatform/editSubscriptionForm.html.twig', [
            'id' => $id,
            'subscriberId' => $id,
            'url' => $this->generateUrl('akeneo_presales_custom_app_essentials_event-platform-create-https-subscription', ['id' => $id]),
            'form' => $form->createView(),
        ])]);
    }

}
