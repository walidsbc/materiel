<?php

namespace SBCPlatformBundle\Form;

use SBCPlatformBundle\Entity\Intervention;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class InterventionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('interferedby', null, array(
                'attr' => array(
                    'class' => 'kendoComboBox',
                    'style' => 'width:100%'
                )
            ))
            ->add('save',SubmitType::class);

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Intervention::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sbcplatformbundle_intervention';
    }





}
