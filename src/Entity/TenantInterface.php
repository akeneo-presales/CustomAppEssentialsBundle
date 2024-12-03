<?php

namespace AkeneoPresales\CustomAppEssentialsBundle\Entity;

interface TenantInterface
{
    public function getDomainName():string;
    public function getClientId():string;
    public function getAccessToken():?string;
}
