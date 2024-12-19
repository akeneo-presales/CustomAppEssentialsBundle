<?php

namespace AkeneoPresales\CustomAppEssentialsBundle\Form\Type;

use AkeneoPresales\CustomAppEssentialsBundle\Entity\UIExtension;
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
            ->add('code', TextType::class, [
                'label' => 'Code',
            ])
            ->add('position', ChoiceType::class, [
                'label' => 'Position',
                'choices' => [
                    'Edit Product Header' => 'edit_product_header',
                    'Edit Root Product Model Header' => 'edit_root_product_model_header',
                    'Edit Sub Product Model Header' => 'edit_sub_product_model_header',
                    'Edit Product Tab' => 'edit_product_tab',
                    'Edit Category Tab' => 'edit_category_tab',
                    'Product Grid Quick Action' => 'product_grid_quick_action',
                ],
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Type',
                'choices' => [
                    'Simple Button' => 'simple_button',
                    'Simple IFrame' => 'simple_iframe',
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

