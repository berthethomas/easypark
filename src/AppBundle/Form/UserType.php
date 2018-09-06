<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('nom', TextType::class, array(
                    'required' => true,
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => "Nom")))
                ->add('prenom', TextType::class, array(
                    'required' => true,
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => "Prénom")))
                ->add('email', EmailType::class, array(
                    'required' => true,
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => "Email")))
                ->add('phonenumber', TextType::class, array(
                    'required' => true,
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => "Numéro de téléphone")))
                ->add('plainPassword', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'options' => array('translation_domain' => 'FOSUserBundle'),
                    'first_options' => array('label' => NULL, 'attr' => array('class' => 'form-control', 'placeholder' => "Mot de passe")),
                    'second_options' => array('label' => NULL, 'attr' => array('class' => 'form-control', 'placeholder' => "Confirmation")),
                    'invalid_message' => 'fos_user.password.mismatch',
                ))
                ->add('type', EntityType::class, array(
                    'class' => 'AppBundle:TypeUser',
                    'choice_label' => 'nom',
                    'placeholder' => "Vous êtes ?",
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
