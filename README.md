# Akeneo Presales Custom Apps Essentials Bundle

All the tools and services that improves and accelerate the Akeneo custom apps development.


### Install
```
composer require akeneo-presales/custom-app-essentials-bundle
```

### Configure

add a routing block in your symfony config/routes.yaml file

```yaml
akeneo_presales_custom_app_essentials:
    resource: "@AkeneoPresalesCustomAppEssentialsBundle/Controller"
    type: attribute

```

Implements the `AkeneoPresales\CustomAppEssentialsBundle\Entity\TenantInterface` Interface on your Tenant Entity

### Capabilities

#### TenantService
