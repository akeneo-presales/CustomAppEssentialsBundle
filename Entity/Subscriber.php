<?php

namespace AkeneoPresales\CustomAppEssentialsBundle\Entity;

class Subscriber
{
    private $id;
    private $name;
    private $technicalEmail;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getTechnicalEmail()
    {
        return $this->technicalEmail;
    }

    public function setTechnicalEmail($technicalEmail)
    {
        $this->technicalEmail = $technicalEmail;
        return $this;
    }
}
