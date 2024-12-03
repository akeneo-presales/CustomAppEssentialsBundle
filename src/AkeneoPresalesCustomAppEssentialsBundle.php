<?php

namespace AkeneoPresales\CustomAppEssentialsBundle;

use AkeneoPresales\CustomAppEssentialsBundle\DependencyInjection\AkeneoPresalesCustomAppEssentialsExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AkeneoPresalesCustomAppEssentialsBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        if (null === $this->extension) {
            $this->extension = new AkeneoPresalesCustomAppEssentialsExtension();
        }
        return $this->extension;
    }
}
