<?php

namespace App\Form;

use App\Entity\MasterLeague;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MasterLeagueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Nombre de la liga master'])
            ->add('initialBudget', IntegerType::class, ['label' => 'Presupuesto inicial'])
            ->add('minPlayers', IntegerType::class, ['label' => 'Minimo de jugadores por equipo'])
            ->add('playersLimit', IntegerType::class, ['label' => 'Maximo de jugadores por equipo'])
            ->add('submit', SubmitType::class, ['label' => 'Crear liga master'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MasterLeague::class,
        ]);
    }
}
