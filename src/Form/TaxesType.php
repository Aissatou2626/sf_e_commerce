<?php

namespace App\Form;

use App\Entity\Taxes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;

class TaxesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                'Placeholder' => 'Taxe'
                ],
                'required' => true
            ])
            ->add('rate', PercentType::class, [
                'attr' => [
                    'Placeholder' => 'Taux'
                ],
                'required' => true                
            ])
            ->add('enable',  CheckboxType::class, [
                'label' => 'Actif',
                'required' => false
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Taxes::class,
        ]);
    }
}
