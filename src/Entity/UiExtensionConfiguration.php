<?php

namespace AkeneoPresales\CustomAppEssentialsBundle\Entity;

class UiExtensionConfiguration
{

    public string $url;

    public array $labels = [];

    public function getLabels(): array
    {
        return $this->labels;
    }

    public function setLabels(array $labels)
    {
        $this->labels = $labels;
        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url)
    {
        dump($url);
        $this->url = $url;
        return $this;
    }

    public function setLabel($locale, $label)
    {
        $this->labels[$locale] = $label;
        return $this;
    }

    public function hasLabel($locale)
    {
        return isset($this->labels[$locale]);
    }
}
