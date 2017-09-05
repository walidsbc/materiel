<?php


namespace SBCPlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class MaterielDesactiverType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('reference')
            ->add('registration')

            ->add('status', ChoiceType::class, array(
                'choices' => array('Perdu' => 'Perdu', 'Introuvale' => 'Introuvale', 'Reclassé' => 'Reclassé'),
                'expanded' => true,
                'multiple' => false,
                'choices_as_values' => true
            ))
            ->add('save', SubmitType::class);

        

    }



    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sbcplatformbundle_materiel_desactiver';
    }


}