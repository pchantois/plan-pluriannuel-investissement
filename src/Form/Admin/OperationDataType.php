<?php

namespace App\Form\Admin;

use App\Entity\Admin\OperationData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class OperationDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('annee')
        ->add('type', ChoiceType::class, [
            'choices' => [
                'Dépense' => true,
                'Recette' => false,
            ]
        ])
            ->add('montant')
            //->add('operation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OperationData::class,
        ]);
    }
}
