<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AdresseType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('numero', TextType::class, array(
                    'required' => false,
                    'label' => "Numéro de rue : ",
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => "Numéro de rue")))
                ->add('nomRue', TextType::class, array(
                    'required' => false,
                    'label' => "Nom de rue : ",
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => "Nom de rue")))
                ->add('lieuDit', TextType::class, array(
                    'required' => false,
                    'label' => "Lieu dit : ",
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => "Lieu dit")))
                ->add('codePostal', TextType::class, array(
                    'required' => false,
                    'label' => "Code Postal : ",
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => "Code Postal")))
                ->add('ville', TextType::class, array(
                    'required' => false,
                    'label' => "Ville : ",
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => "Ville")))
        ;
    }

/**
     * {@inheritdoc}
     */

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Adresse'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'appbundle_adresse';
    }

}
