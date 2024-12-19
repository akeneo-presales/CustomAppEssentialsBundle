<?php

namespace AkeneoPresales\CustomAppEssentialsBundle\Entity;

class UiExtensionConfiguration
{

    public string $url;

    public string $defaultLabel;

    public array $labels = [];

    public function getLabels(): array
    {
        return $this->labels;
    }

    public function setLabels(array $labels): UiExtensionConfiguration
    {
        $this->labels = $labels;
        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): UiExtensionConfiguration
    {
        $this->url = $url;
        return $this;
    }

    public function setLabel($locale, $label): UiExtensionConfiguration
    {
        $this->labels[$locale] = $label;
        return $this;
    }

    public function hasLabel($locale)
    {
        return isset($this->labels[$locale]);
    }

    public function getDefaultLabel(): string
    {
        return $this->defaultLabel;
    }

    public function setDefaultLabel(string $defaultLabel): UiExtensionConfiguration
    {
        $this->defaultLabel = $defaultLabel;
        return $this;
    }

}
