<?php

namespace AkeneoPresales\CustomAppEssentialsBundle\Controller;

use AkeneoPresales\CustomAppEssentialsBundle\Entity\Subscriber;
use AkeneoPresales\CustomAppEssentialsBundle\Form\Type\SubscriberType;
use AkeneoPresales\CustomAppEssentialsBundle\Service\GetTenantService;
use AkeneoPresales\CustomAppEssentialsBundle\Service\AkeneoEventPlatformService;
use App\Storage\UserProfileSessionStorage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EventPlatformCreateSubscriberAction extends AbstractController
{
    #[Route('/event-platform/subscriber/new', name: 'akeneo_presales_custom_app_essentials_event-platform-create-subscriber', methods: ['GET', 'POST'])]
    public function __invoke(Request $request,  GetTenantService $getTenantService, UserProfileSessionStorage $profileSessionStorage)
    {
        $tenant = $getTenantService->getTenant($request);

        $akeneoEventPlatformService = new AkeneoEventPlatformService();

        $subObj = new Subscriber();
        $subObj->setTechnicalEmail($profileSessionStorage->getUserProfileEmail());
        $form = $this->createForm(SubscriberType::class, $subObj);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $akeneoEventPlatformService->createSubscriber($tenant, $subObj->getName(), $subObj->getTechnicalEmail());
            $this->addFlash('success', 'Subscriber created  successfully.');
            return $this->redirectToRoute('akeneo_presales_custom_app_essentials_event_platform_configuration');
        }

        return $this->json(['result' => $this->renderView('@AkeneoPresalesCustomAppEssentials/eventPlatform/editSubscriberForm.html.twig', [
            'form' => $form->createView(),
            'url' => $this->generateUrl('akeneo_presales_custom_app_essentials_event-platform-create-subscriber'),
        ])]);
    }

}
