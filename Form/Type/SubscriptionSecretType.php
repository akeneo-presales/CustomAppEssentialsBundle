<?php

namespace AkeneoPresales\CustomAppEssentialsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class SubscriptionSecretType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('primary', TextType::class, [
                'label' => 'Primary',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Your primary secret to sign the payload',
                ],
            ])
            ->add('secondary', TextType::class, [
                'label' => 'Secondary',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Optional secondary secret for secret rotation',
                ],
            ]);
    }
}
