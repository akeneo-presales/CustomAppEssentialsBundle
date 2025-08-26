<?php

namespace AkeneoPresales\CustomAppEssentialsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class SubscriptionHttpsConfigType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('url', TextType::class, [
                'label' => 'Webhook URL',
                'required' => true,
                'help' => 'The URL to which the webhook payloads will be delivered. Get a free and simple webhook URL at https://webhook.site/',
                'attr' => [
                    'placeholder' => 'https://your_webhook_url',
                ],
            ])
            ->add('secret', SubscriptionSecretType::class, [
                'label' => 'Secret',
            ]);
    }
}
