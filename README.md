# Akeneo Presales Custom Apps Essentials Bundle

All the tools and services that improves and accelerate the Akeneo custom apps development.


### Install
```
composer require akeneo-presales/custom-app-essentials-bundle
```

### Configure

- Add a routing block in your symfony config/routes.yaml file

```yaml
akeneo_presales_custom_app_essentials:
    resource: "@AkeneoPresalesCustomAppEssentialsBundle/Controller"
    type: attribute

```

- Implements the `AkeneoPresales\CustomAppEssentialsBundle\Entity\TenantInterface` Interface on your Tenant Entity

### Capabilities

#### Akeneo Event Platform Management web interface

A simple UI to ease the configuration of subscribers and subscriptions
- Add link to the Akeneo Event Platform management web interface :
```html
<a href="{{ path('akeneo_presales_custom_app_essentials_event_platform_configuration') }}">Event Platform</a>
```

#### Akeneo UI Extensions Management web interface (WIP)

A simple UI to ease the configuration of the Akeneo UI Extensions (To Come)
- Add link to the Akeneo UI extensions management web interface :
```html
<a href="{{ path('akeneo_presales_custom_app_essentials_ui_extension_index') }}">UI Extensions</a>
```

#### GraphQL Client

see service class [src/Service/GraphQLService.php]()


#### PubSub Service

see service class [src/Service/PubSubService.php]()


