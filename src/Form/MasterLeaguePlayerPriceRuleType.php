<?php

namespace App\Form;

use App\Entity\MasterLeague;
use App\Entity\MasterLeaguePlayerPriceRule;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MasterLeaguePlayerPriceRuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ratingFrom', IntegerType::class, ['label' => 'Desde'])
            ->add('ratingTo', IntegerType::class, ['label' => 'Hasta'])
            ->add('price', IntegerType::class, ['label' => 'Precio'])
            ->add('submit', SubmitType::class, ['label' => 'Crear regla', 'attr' => ['class' => 'btn btn-primary']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MasterLeaguePlayerPriceRule::class,
        ]);
    }
}
