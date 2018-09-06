<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class OffreType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $offre = $builder->getData();

        $builder
                ->add('prix', NumberType::class, array(
                    'required' => true,
                    'label' => "Prix (par jour) : ",
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => "Prix")))
                ->add('titre', TextType::class, array(
                    'required' => true,
                    'label' => "Titre : ",
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => "Titre")))
                ->add('description', TextareaType::class, array(
                    'required' => true,
                    'label' => "Description : ",
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => "Description")))
                ->add('dateDebutValiditee', TextType::class, array(
                    'required' => true,
                    'label' => "Date de début de disponibilité : ",
                    'attr' => array(
                        'class' => 'form-control form_datetime',
                        'placeholder' => "Date de début de disponibilité")))
                ->add('dateFinValiditee', TextType::class, array(
                    'required' => true,
                    'label' => "Date de fin de disponibilité : ",
                    'attr' => array(
                        'class' => 'form-control form_datetime',
                        'placeholder' => "Date de fin de disponibilité")))
                ->add('type', EntityType::class, array(
                    'label' => "Type d'emplacement : ",
                    'class' => 'AppBundle:TypeOffre',
                    'choice_label' => 'nom',
                    'placeholder' => "Type d'emplacement",
                    'mapped' => true,
                    'required' => true,
                    'attr' => array('class' => 'form-control')))
                ->add('adresse', AdresseType::class)
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
            $data = $event->getData();
            if ($data->getDateDebutValiditee() !== NULL) {
                $data->setDateDebutValiditee($data->getDateDebutValiditee()->format('d/m/Y - H:i'));
            }
            if ($data->getDateFinValiditee() !== NULL) {
                $data->setDateFinValiditee($data->getDateFinValiditee()->format('d/m/Y - H:i'));
            }
            $event->setData($data);
        });

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) {
            $data = $event->getData();
            if (isset($data['dateDebutValiditee'])) {
                $data['dateDebutValiditee'] = \DateTime::createFromFormat('j/m/Y - H:i:s', $data['dateDebutValiditee'] . ":00");
            }
            if (isset($data['dateFinValiditee'])) {
                $data['dateFinValiditee'] = \DateTime::createFromFormat('j/m/Y - H:i:s', $data['dateFinValiditee'] . ":00");
            }
            $event->setData($data);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Offre'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'appbundle_offre';
    }

}
