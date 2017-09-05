<?php


namespace SBCPlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class OuvrierEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


    }



    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sbcplatformbundle_ouvrier_edit';
    }

    public function getParent()
    {
        return OuvrierType::class;
    }
}