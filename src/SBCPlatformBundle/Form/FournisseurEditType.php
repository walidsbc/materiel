<?php

namespace SBCPlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;

class FournisseurEditType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->remove('creationdate')
        ->remove('website')
        ->add('website',UrlType::class);
    }



    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sbcplatformbundle_fournisseur_edit';
    }

    public function getParent()
    {
        return FournisseurType::class;
    }

}
