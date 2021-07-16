<?php

namespace App\Form\Admin;

use App\Entity\Admin\Quartier;
use App\Entity\Admin\CodeMaire;
use App\Entity\Admin\NatureOpe;
use App\Entity\Admin\Operation;
use App\Entity\Admin\PolitiquePub;
use App\Entity\Admin\OperationData;
use App\Entity\Admin\RegroupementOpe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OperationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code')
            ->add('libelle')
            ->add('description')
            ->add('commentaire')
            ->add('regroupementOpe', EntityType::class, [
                'class'         => RegroupementOpe::class,
                'choice_label'  => 'libelle',
                'placeholder'   => 'Regroupement',
                'multiple'      => false,
                'expanded'      => false,
            ])
            ->add('quartier', EntityType::class, [
                'class'         => Quartier::class,
                'choice_label'  => 'libelle',
                'multiple'      => false,
                'expanded'      => false,
            ])
            ->add('codeMaire', EntityType::class, [
                'class'         => CodeMaire::class,
                'choice_label'  => 'libelle',
                'multiple'      => false,
                'expanded'      => false,
            ])
            ->add('natureOpe', EntityType::class, [
                'class'         => NatureOpe::class,
                'choice_label'  => 'libelle',
                'multiple'      => false,
                'expanded'      => false,
            ])
            ->add('politiquePub', EntityType::class, [
                'class'         => PolitiquePub::class,
                'choice_label'  => 'libelle',
                'multiple'      => false,
                'expanded'      => false,
            ])
            ->add('dob')
            ->add('recueil')
            ->add('DateLivraison')
            ->add('CoutParti')
            ->add('coutTotal')
            ->add('operationData', EntityType::class, [
                'class'         => OperationData::class,
                'choice_label'  => 'montant',
                'multiple'      => true,
                'expanded'      => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Operation::class,
        ]);
    }
}
