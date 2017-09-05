<?php


namespace SBCPlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class ChantierEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->remove('creationdate');

    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sbcplatformbundle_chantier_edit';
    }

    public function getParent()
    {
        return ChantierType::class;
    }
}