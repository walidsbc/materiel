<?php

namespace SBCPlatformBundle\Form;

use SBCPlatformBundle\Entity\InterventionCurative;
use SBCPlatformBundle\Entity\TypeIntervention;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class InterventionCurativeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('materiel', null, array(
                'attr' => array(
                    'class' => 'kendoComboBox',
                    'style' => 'width:100%'
                )
            ))
            ->add('natureintervention', null, array(
                'attr' => array(
                    'class' => 'kendoComboBox select',
                    'style' => 'width:100%',
                    'placeholder' => 'Choisir la nature d\'intervention'
                )
            ));

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => InterventionCurative::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sbcplatformbundle_intervention_curative';
    }

    public function getParent()
    {
        return InterventionType::class;
    }

}
