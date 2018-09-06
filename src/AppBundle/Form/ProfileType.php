<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProfileType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('nom', TextType::class, array(
                    'required' => true,
                    'label' => "Nom : ",
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => "Nom")))
                ->add('prenom', TextType::class, array(
                    'required' => true,
                    'label' => "Prénom : ",
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => "Prénom")))
                ->add('email', EmailType::class, array(
                    'required' => true,
                    'label' => "Email : ",
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => "Email")))
                ->add('phonenumber', TextType::class, array(
                    'required' => true,
                    'label' => "Numéro de téléphone : ",
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => "Numéro de téléphone")))
                ->add('type', EntityType::class, array(
                    'label' => "Catégorie : ",
                    'class' => 'AppBundle:TypeUser',
                    'choice_label' => 'nom',
                    'placeholder' => "Vous êtes ?",
                    'mapped' => true,
                    'required' => true,
                    'attr' => array('class' => 'form-control')))
                ->add('vehicule', EntityType::class, array(
                    'label' => "Véhicule : ",
                    'class' => 'AppBundle:Vehicule',
                    'choice_label' => 'nom',
                    'placeholder' => "Quel est votre véhicule",
                    'mapped' => true,
                    'required' => true,
                    'attr' => array('class' => 'form-control')))
                ;
    }

/**
     * {@inheritdoc}
     */

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'appbundle_user';
    }

}
