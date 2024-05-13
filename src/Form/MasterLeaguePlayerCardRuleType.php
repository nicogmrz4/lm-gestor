<?php

namespace App\Form;

use App\Entity\MasterLeague;
use App\Entity\MasterLeaguePlayerCardRule;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MasterLeaguePlayerCardRuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cardType', TextType::class, ['label' => 'Tipo de tarjeta'])
            ->add('price', IntegerType::class, ['label' => 'Costo'])
            ->add('onceTime', CheckboxType::class, [
                'label' => 'Por unica vez'
            ])
            ->add('submit', SubmitType::class, ['label' => 'Crear regla', 'attr' => ['class' => 'btn btn-primary']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MasterLeaguePlayerCardRule::class,
        ]);
    }
}
