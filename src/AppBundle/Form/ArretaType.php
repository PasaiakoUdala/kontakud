<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArretaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fetxa')
            ->add('nan')
            ->add('kanala',EntityType::class,array(
                'class' => 'AppBundle:Kanala',
                'expanded' => true,
                'multiple' => false,
                'label_attr' => array(
                    'class' => 'radio-inline'
                ),
                'label'     => 'frm.arreta.new.kanala',
                'choice_translation_domain' => 'messages'
            ))
            ->add('remitente', ChoiceType::class, array(
                'choices' => array(
                    'Persona individual' => 'Individual',
                    'Administración / Empresa' => 'Administración/Empresa'
                ),
                'choices_as_values' => true,
                'multiple'=>false,
                'expanded'=>true,
                'label_attr' => array(
                    'class' => 'radio-inline'
                ),
                'label'     => 'frm.arreta.new.remitente',
                'choice_translation_domain' => 'messages'
            ))
            ->add('genero', ChoiceType::class, array(
                'choices' => array(
                    'Femenino' => 'Femenino',
                    'Masculino' => 'Masculino'
                ),
                'choices_as_values' => true,
                'multiple'=>false,
                'expanded'=>true,
                'label_attr' => array(
                    'class' => 'radio-inline'
                ),
                'label'     => 'frm.arreta.new.genero',
                'choice_translation_domain' => 'messages'

            ))
            ->add('adina', ChoiceType::class, array(
                'choices' => array(
                    'Hasta 30' => '<30',
                    '31-65' => '31-65',
                    'Mayor 65' => '>65'
                ),
                'choices_as_values' => true,
                'multiple'=>false,
                'expanded'=>true,
                'label_attr' => array(
                    'class' => 'radio-inline'
                ),
                'label'     => 'frm.arreta.new.adina',
                'choice_translation_domain' => 'messages'
            ))
            ->add('nazionalitatea', ChoiceType::class, array(
                'choices' => array(
                    'Española' => 'Española',
                    'Otro' => 'Otro'
                ),
                'choices_as_values' => true,
                'multiple'=>false,
                'expanded'=>true,
                'label_attr' => array(
                    'class' => 'radio-inline'
                ),
                'label'     => 'frm.arreta.new.nazionalitatea',
                'choice_translation_domain' => 'messages'
            ))
            ->add('hizkuntza', ChoiceType::class, array(
                'choices' => array(
                    'Euskera' => 'Euskera',
                    'Castellano' => 'Castellano',
                    'Otra' => 'Otra'
                ),
                'choices_as_values' => true,
                'multiple'=>false,
                'expanded'=>true,
                'label_attr' => array(
                    'class' => 'radio-inline'
                ),
                'label'     => 'frm.arreta.new.hizkuntza',
                'choice_translation_domain' => 'messages'
            ))
            ->add('barrutia', ChoiceType::class, array(
                'choices' => array(
                    'Donibane' => 'Donibane',
                    'Trintxerpe' => 'Trintxerpe',
                    'Antxo' => 'Antxo',
                    'San Pedro' => 'San Pedro'
                ),
                'choices_as_values' => true,
                'multiple'=>false,
                'expanded'=>true,
                'label_attr' => array(
                    'class' => 'radio-inline'
                ),
                'label'     => 'frm.arreta.new.barrutia',
                'choice_translation_domain' => 'messages'
            ))
            ->add('administrazioa', ChoiceType::class, array(
                'choices' => array(
                    'Municipal' => 'Municipal',
                    'Provincial' => 'Provincial',
                    'Autonomica' => 'Autonomica',
                    'Estatal' => 'Estatal',
                    'Justicia' => 'Justicia',
                    'Osakidetza' => 'Osakidetza'
                ),
                'choices_as_values' => true,
                'multiple'=>false,
                'expanded'=>true,
                'label_attr' => array(
                    'class' => 'radio-inline'
                ),
                'label'     => 'frm.arreta.new.administrazioa',
                'choice_translation_domain' => 'messages'
            ))
            ->add('oharra')
            ->add('isclosed')
            ->add('user');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Arreta'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_arreta';
    }


}
