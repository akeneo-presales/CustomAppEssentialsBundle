<?php

namespace AkeneoPresales\CustomAppEssentialsBundle\Entity\Transformer;

use AkeneoPresales\CustomAppEssentialsBundle\Entity\UiExtensionConfiguration;

class UIExtensionConfigurationTransformer
{
    public static function apiResultToObject($result): UiExtensionConfiguration
    {
        $configuration = new UIExtensionConfiguration();
        $configuration->setUrl($result['url']);
        $configuration->setDefaultLabel($result['default_label']);
        $configuration->setLabels($result['labels']);
        return $configuration;
    }

    public static function objectToApiResult(UiExtensionConfiguration $extensionConfiguration): array
    {
        $labels = $extensionConfiguration->getLabels();
        foreach ($labels as $locale => $label) {
            if($label == '') {
                unset($labels[$locale]);
            }
        }

        $tab = [
            'url' => $extensionConfiguration->getUrl(),
            'secret' => $extensionConfiguration->getSecret(),
            'default_label' => $extensionConfiguration->getDefaultLabel(),
            'labels' => $labels,
        ];

        if(!$extensionConfiguration->getSecret()) {
            unset($tab['secret']);
        }

        return $tab;
    }

}
