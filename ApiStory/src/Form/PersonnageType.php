<?php

namespace App\Form;


use App\Entity\Personnage;
use App\Entity\Lieux;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class PersonnageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class, array('label'=>"Nom"))
            ->add('prenom',TextType::class, array('label'=>"Prénom"))
            ->add('origine', EntityType::class,['class'=>Lieux::class, 'choice_label'=>'nom'],[
                  'placeholder' => 'Choisit un lieux',] )
            ->add('description_physique',TextareaType::class, array('label'=>"Détail physique"))
            ->add('description_psychologique',TextareaType::class, array('label'=>"Détail personnalité"))
            ->add('principal',ChoiceType::class, ['choices'=>['principal'=>true,'secondaire'=>false],'label'=>'Rôle']);
//            ->add('enfants', ChoiceType::class,[])
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Personnage::class,
        ]);
    }
}


