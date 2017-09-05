<?php


namespace SBCPlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class MaterielEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        $builder
//            ->remove('factureFile')
//            ->add('factureFile', \Symfony\Component\Form\Extension\Core\Type\FileType::class, array(
//                'required' => false,
////                'attr' => array('data-default-file'=>'url_of_your_file')
//
//            ));


    }


    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sbcplatformbundle_materiel_edit';
    }

    public function getParent()
    {
        return MaterielType::class;
    }
}