<?php

namespace AkeneoPresales\CustomAppEssentialsBundle\Form\Type;

use AkeneoPresales\CustomAppEssentialsBundle\Entity\UIExtension;
use AkeneoPresales\CustomAppEssentialsBundle\Enum\UIextensionsEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UIExtensionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('uuid', HiddenType::class, [
            ])
            ->add('name', TextType::class, [
                'label' => 'Name',
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
            ])
            ->add('position', ChoiceType::class, [
                'label' => 'Position',
                'choices' => UIextensionsEnum::POSITIONS_FORM_OPTIONS,
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Type',
                'choices' => [
                    'Button' => 'open',
                    'IFrame' => 'iframe',
                ],
            ])
            ->add('configuration', UIExtensionConfigurationType::class, [
                'label' => 'Configuration',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UiExtension::class,
        ]);
    }
}

