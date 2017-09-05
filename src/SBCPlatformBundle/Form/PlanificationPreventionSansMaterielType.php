<?php

namespace SBCPlatformBundle\Form;


use SBCPlatformBundle\Entity\PlanificationPrevention;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class PlanificationPreventionSansMaterielType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('threshold', IntegerType::class, array(
                    'label' => 'Seuil',
                    'attr' => array(
                        'class' => 'md-input',
                        'data-name' => 'threshold',
                        'required' => true
                    )
                )
            )
            ->add('cyclevalue', IntegerType::class, array(
                    'label' => 'Valeur du cycle',
                    'attr' => array(
                        'class' => 'md-input',
                        'data-name' => 'cyclevalue',
                        'required' => true
                    )
                )
            )

            ->add('natureintervention',null,array(
                'attr' => array(
                    'data-name' => 'natureintervention',
                    'class' => 'kendoComboBox select',
                    'style' => 'width:100%',
                    'required' => true
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
            'data_class' => PlanificationPrevention::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sbcplatformbundle_planification_prevention';
    }



}
