<?php

namespace SBCPlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class DepotEditType extends AbstractType
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
        return 'sbcplatformbundle_depot_edit';
    }

    public function getParent()
    {
        return DepotType::class;
    }

}
