<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Form;

use App\Entity\Auteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * Description of AuteurFormType
 *
 * @author p.battisti
 */
class AuteurFormType extends AbstractType{
   public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class, array('label'=>"Nom", 'required'=>false))
            ->add('prenom',TextType::class, array('label'=>"Prénom", 'required'=>false))
            ->add('photo', FileType::class , array ('label'=>"Sélectionner photo", 'required'=>false))
            ->add('bibliographie',TextareaType::class,array('label'=>'Bibliographie'))
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Auteur::class,
        ]);
    }
}
