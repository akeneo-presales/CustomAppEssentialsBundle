<?php

namespace AkeneoPresales\CustomAppEssentialsBundle\Entity;

class Subscription
{
    private $id;
    private $type;
    private $config = [];

    private $events = [];

    public function getEvents(): array
    {
        return $this->events;
    }

    public function setEvents(array $events): Subscription
    {
        $this->events = $events;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getConfig() :array
    {
        return $this->config;
    }

    public function setConfig(array $config)
    {
        $this->config = $config;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
}
