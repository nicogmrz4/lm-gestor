<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
                ->add('username', TextType::class, [
                    'label' => 'Nombre de usuario'
                ])
                ->add('email', EmailType::class, [
                    'label' => 'Email'
                ])
                ->add('password', PasswordType::class, [
                    'label' => 'Contraseña',
                    'mapped' => false
                ])
                ->add('roleAdmin',CheckboxType::class, [
                    'label' => 'Administrador',
                    'mapped' => false
                ])
                ->add('submit', SubmitType::class, [
                    'label' => 'Crear usuario',
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
