<?php

namespace SBCPlatformBundle\Form;

use SBCPlatformBundle\Entity\InterventionPreventive;
use SBCPlatformBundle\Entity\NatureIntervention;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class InterventionPreventiveType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('planificationPreventive',null,array(
                'attr' => array(
                    'class' => 'kendoComboBox select',
                    'style' => 'width:100%',
                    'placeholder' => 'Choisir la planification'
                )
            ))
          ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => InterventionPreventive::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sbcplatformbundle_intervention_preventive';
    }


    public function getParent()
    {
        return InterventionType::class;
    }


}
