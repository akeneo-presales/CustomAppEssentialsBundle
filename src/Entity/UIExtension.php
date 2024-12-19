<?php

namespace AkeneoPresales\CustomAppEssentialsBundle\Entity;
class UIExtension
{

    private ?string $uuid = null;

    private string $code;

    private string $position;

    private string $type;

    private UiExtensionConfiguration $configuration;

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;
        return $this;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): UIExtension
    {
        $this->code = $code;
        return $this;
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    public function setPosition(string $position): self
    {
        $this->position = $position;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getConfiguration(): UiExtensionConfiguration
    {
        return $this->configuration;
    }

    public function setConfiguration(UiExtensionConfiguration $configuration): self
    {
        $this->configuration = $configuration;
        return $this;
    }
}
