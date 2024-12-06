<?php

namespace AkeneoPresales\CustomAppEssentialsBundle\Entity\Transformer;

use AkeneoPresales\CustomAppEssentialsBundle\Entity\UiExtensionConfiguration;

class UIExtensionConfigurationTransformer
{
    public static function apiResultToObject($result): UiExtensionConfiguration
    {
        $configuration = new UIExtensionConfiguration();
        $configuration->setUrl($result['url']);
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

        return [
            'url' => $extensionConfiguration->getUrl(),
            'labels' => $labels,
        ];
    }

}
