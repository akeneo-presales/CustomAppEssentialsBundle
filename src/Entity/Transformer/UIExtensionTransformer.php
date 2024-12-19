<?php

namespace AkeneoPresales\CustomAppEssentialsBundle\Entity\Transformer;

use AkeneoPresales\CustomAppEssentialsBundle\Entity\UIExtension;

class UIExtensionTransformer
{

    public static function apiResultToObject($result): UIExtension
    {
        $uiExtension = new UIExtension();
        $uiExtension->setUuid($result['uuid']);
        $uiExtension->setCode($result['code']);
        $uiExtension->setPosition($result['position']);
        $uiExtension->setType($result['type']);
        $uiExtension->setConfiguration(UIExtensionConfigurationTransformer::apiResultToObject($result['configuration']));
        return $uiExtension;
    }

    public static function objectToApiResult(UIExtension $extension): array
    {
        return [
            'code' => $extension->getCode(),
            'position' => $extension->getPosition(),
            'type' => $extension->getType(),
            'configuration' => UIExtensionConfigurationTransformer::objectToApiResult($extension->getConfiguration()),
        ];
    }
}
