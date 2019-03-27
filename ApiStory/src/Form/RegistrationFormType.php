<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password', RepeatedType::class, [
             'type' => PasswordType::class,
             'invalid_message' => 'The password fields must match.',
             'options' => ['attr' => ['class' => 'password-field form-label-group form-control']],
             'required' => true,
             'first_options'  => ['label' => 'Password'],
             'second_options' => ['label' => 'Repeat Password'],
             'constraints' => [
                             new NotBlank([
                                 'message' => 'Please enter a password',
                             ]),
                             new Length([
                                 'min' => 6,
                                 'minMessage' => 'Your password should be at least {{ limit }} characters',
                                 // max length allowed by Symfony for security reasons
                                 'max' => 4096,
                             ]),
                         ],
         ]);
                
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
