<?php

namespace AkeneoPresales\CustomAppEssentialsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class SubscriptionPubSubConfigType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('project_id', TextType::class, ['label' => 'GCP Project Id']);
        $builder->add('topic_id', TextType::class, ['label' => 'Pub Sub Topic Id']);
    }
}
