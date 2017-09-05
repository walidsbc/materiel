<?php

// src/OC/PlatformBundle/Form/ImageType.php

namespace SBCPlatformBundle\Form;

use SBCPlatformBundle\Entity\Fichier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class FileType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', \Symfony\Component\Form\Extension\Core\Type\FileType::class, array(
                'required' => false,
//                'allow_delete' => false, // not mandatory, default is true
//                'download_link' => false, // not mandatory, default is true
//                'attr' => array('class' => 'dropify-fr', 'label'=>'Fichier', 'required' => true )
                'attr' => array(
                    'data-name' => 'file',
                )

            ))
            ->add('description', TextType::class,array(
                'attr' => array('data-name' => 'description','class' => 'md-input', 'label'=>'Description', 'required' => true)
            ));
    }


    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Fichier::class

        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sbcplatformundle_file';
    }


}
