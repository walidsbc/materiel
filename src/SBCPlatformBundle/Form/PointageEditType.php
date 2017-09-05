<?php


namespace SBCPlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class PointageEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


    }



    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sbcplatformbundle_pointage_edit';
    }

    public function getParent()
    {
        return PointageType::class;
    }
}