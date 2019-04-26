<?php

namespace App\Form;

use App\Entity\Lieux;
use App\Entity\Monde;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class LieuxFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom')
            ->add('pays')
            ->add('ville')
            ->add('description')
            ->add('monde', EntityType::class,['class'=>Monde::class,'choice_label'=>'nom'],['placeholder'=>'Choisit un monde'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lieux::class,
        ]);
    }
}
