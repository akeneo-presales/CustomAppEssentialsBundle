<?php
namespace AkeneoPresales\CustomAppEssentialsBundle\Controller;

use AkeneoPresales\CustomAppEssentialsBundle\Entity\UIExtension;
use AkeneoPresales\CustomAppEssentialsBundle\Entity\UiExtensionConfiguration;
use AkeneoPresales\CustomAppEssentialsBundle\Enum\UIextensionsEnum;
use AkeneoPresales\CustomAppEssentialsBundle\Form\Type\UIExtensionType;
use AkeneoPresales\CustomAppEssentialsBundle\Service\AkeneoUIExtensionService;
use AkeneoPresales\CustomAppEssentialsBundle\Service\GetTenantService;
use GuzzleHttp\Exception\RequestException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ui-extensions', name: 'akeneo_presales_custom_app_essentials_ui_extension_')]
class UIExtensionController extends AbstractController
{
    public function __construct(
        private readonly AkeneoUIExtensionService $uiExtensionService,
        private readonly GetTenantService $getTenantService
    ) {
    }

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $tenant = $this->getTenantService->getTenant($request);

        // Fetch the extensions directly from the service
        $extensions = $this->uiExtensionService->listExtensions($tenant);

        return $this->render('@AkeneoPresalesCustomAppEssentials/UIExtensions/index.html.twig', [
            'extensions' => $extensions,
            'tenant' => $tenant,
            'contextual_nav' => 'secondary-nav-config',
        ]);
    }

    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $tenant = $this->getTenantService->getTenant($request);

        $extension = new UIExtension();
        $configuration = new UIExtensionConfiguration();
        foreach (UIextensionsEnum::AVAILABLE_UI_LOCALES as $locale => $localeCode) {
            $configuration->setLabel($localeCode, '');
        }
        $extension->setConfiguration($configuration);

        $form = $this->createForm(UIExtensionType::class, $extension);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $result = $this->uiExtensionService->upsertExtension($tenant, $extension);
                if(null !== $result) {
                    $this->addFlash('success', 'Extension created!');
                }

                return $this->redirectToRoute('akeneo_presales_custom_app_essentials_ui_extension_index');
            } catch (\Exception $exception) {
                $this->addFlash('error', $exception->getMessage());
            }
        }

        return $this->render('@AkeneoPresalesCustomAppEssentials/UIExtensions/create.html.twig', [
            'form' => $form->createView(),
            'title' => 'Create UI Extension',
            'contextual_nav' => 'secondary-nav-config',
        ]);
    }


    #[Route('/update/{extensionCode}', name: 'update', methods: ['GET', 'POST'])]
    public function update(Request $request, $extensionCode): Response
    {
        $tenant = $this->getTenantService->getTenant($request);

        $extension = $this->uiExtensionService->getExtension($tenant, $extensionCode);

        foreach (UIextensionsEnum::AVAILABLE_UI_LOCALES as $locale => $localeCode) {
            if(!$extension->getConfiguration()->hasLabel($localeCode)) {
                $extension->getConfiguration()->setLabel($localeCode, '');
            }
        }

        $form = $this->createForm(UIExtensionType::class, $extension);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Use the service to upsert the extension
            try {
                $result = $this->uiExtensionService->upsertExtension($tenant, $extension);

                if(null !== $result) {
                    $this->addFlash('success', 'Extension updated!');
                }

                return $this->redirectToRoute('akeneo_presales_custom_app_essentials_ui_extension_index');
            } catch (RequestException $exception) {
                $this->addFlash('error', $exception->getMessage());
            }
        }

        return $this->render('@AkeneoPresalesCustomAppEssentials/UIExtensions/create.html.twig', [
            'form' => $form->createView(),
            'title' => 'Edit UI Extension',
            'contextual_nav' => 'secondary-nav-config',
        ]);
    }

    #[Route('/{code}/delete', name: 'delete', methods: ['POST'])]
    public function delete(string $code, Request $request): Response
    {
        $tenant = $this->getTenantService->getTenant($request);

        $success = $this->uiExtensionService->deleteExtension($tenant, $code);

        if ($success) {
            $this->addFlash('success', 'Extension deleted!');
        } else {
            $this->addFlash('error', 'Failed to delete the extension.');
        }

        return $this->redirectToRoute('akeneo_presales_custom_app_essentials_ui_extension_index');
    }
}
