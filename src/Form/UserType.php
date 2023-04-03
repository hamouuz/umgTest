<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles')
            ->add('password', TextType::class, [
                'mapped'=>false
            ])
        ;

       //roles field data transformer
        $builder->get('roles')
                ->addModelTransformer(new CallbackTransformer(
        function ($rolesAsArray) {
             return count($rolesAsArray) ? $rolesAsArray[0]: null;
        },
        function ($rolesAsString) {
             return [$rolesAsString];
        }
));

        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
