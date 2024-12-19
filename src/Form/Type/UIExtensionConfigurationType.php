<?php

namespace AkeneoPresales\CustomAppEssentialsBundle\Form\Type;

use AkeneoPresales\CustomAppEssentialsBundle\Entity\UiExtensionConfiguration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UIExtensionConfigurationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url', UrlType::class, [
                'label' => 'URL',
                'required' => true,
            ])
            ->add('defaultLabel', TextType::class, [
                'label' => 'Default Label',
                'required' => true,
            ])
            ->add('labels', CollectionType::class, [
                'entry_type' => TextType::class,
                'entry_options' => [
                    'label_format' => 'Label in %name%',
                    'required' => false,
                ],
                'allow_add' => false,
                'allow_delete' => false,
                'label' => 'Labels',
            ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UiExtensionConfiguration::class,
        ]);
    }
}
