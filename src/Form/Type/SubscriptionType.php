<?php

namespace AkeneoPresales\CustomAppEssentialsBundle\Form\Type;

use AkeneoPresales\CustomAppEssentialsBundle\Entity\Subscription;
use AkeneoPresales\CustomAppEssentialsBundle\Enum\EventPlatformEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('id', HiddenType::class)
            ->add('type', HiddenType::class)
            ->add('events', ChoiceType::class, ['expanded' => false, 'multiple' => true, 'choices' => EventPlatformEnum::EVENTS]);

        if($options['subscription_form_type'] == 'https') {
            $builder->add('config', SubscriptionHttpsConfigType::class);
        } else {
            $builder->add('config', SubscriptionPubSubConfigType::class);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Subscription::class,
            'allow_extra_fields' => true,
            'subscription_form_type' => null
        ]);
    }


}
