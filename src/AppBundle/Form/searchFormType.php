<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class searchFormType extends AbstractType
{
    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        $builder
//            ->add('kanala',EntityType::class,array(
//                'class' => 'AppBundle:Kanala',
//                'label'     => 'frm.arreta.new.kanala',
//                'choice_translation_domain' => 'messages',
//                'required' => false
//            ))
//            ->add('barrutia', ChoiceType::class, array(
//                'choices' => array(
//                    'Donibane' => 'Donibane',
//                    'Trintxerpe' => 'Trintxerpe',
//                    'Antxo' => 'Antxo',
//                    'San Pedro' => 'San Pedro',
//                    'Beste batzuk / Otros' => 'Beste batzuk / Otros'
//                ),
//                'label'     => 'frm.arreta.new.barrutia',
//                'choice_translation_domain' => 'messages',
//                'required' => false
//            ))
            ->add('fIni', DateType::class, [
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'label' => 'Hasiera data',
                'required' => false
            ])
            ->add('fFin', DateType::class, [
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'label' => 'Amaiera data',
                'required' => false
            ])
            ->add('Onartu', SubmitType::class)

            ;
    }

    public function configureOptions( OptionsResolver $resolver )
    {

    }

    public function getBlockPrefix()
    {
        return 'app_bundlesearch_form_type';
    }
}
