<?php

namespace SBCPlatformBundle\Form;

use SBCPlatformBundle\Entity\Emplacement;
use SBCPlatformBundle\Entity\Materiel;
use SBCPlatformBundle\Entity\Ouvrier;
use SBCPlatformBundle\Entity\Pointage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class PointageType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('creationdate',TextType::class)
            ->add('usedduration')
            ->add('pointedby', Select2EntityType::class, [
                'multiple' => false,
                'remote_route' => 'ouvrier_liste_for_select2',
                'class' => 'SBCPlatformBundle:Ouvrier',
                'primary_key' => 'id',
                'text_property' => 'name',
                'minimum_input_length' => 0,
                'page_limit' => 10,
                'allow_clear' => true,
                'delay' => 250,
                'cache' => true,
                'cache_timeout' => 60000, // if 'cache' is true
                'language' => 'fr',
                'placeholder' => 'Choisir ...',
                'required' =>true,
            ])
            ->add('materiel', Select2EntityType::class, [
                'multiple' => false,
                'remote_route' => 'materiels_liste_pointage',
                'class' => 'SBCPlatformBundle:Materiel',
                'primary_key' => 'id',
                'text_property' => 'name',
                'minimum_input_length' => 0,
                'page_limit' => 10,
                'allow_clear' => true,
                'delay' => 250,
                'cache' => true,
                'cache_timeout' => 60000, // if 'cache' is true
                'language' => 'fr',
                'placeholder' => 'Choisir ...',
                'required' =>true,
            ])

            ->add('emplacement', Select2EntityType::class, [
                'multiple' => false,
                'remote_route' => 'emplacement_liste_for_select2',
                'class' => 'SBCPlatformBundle:Emplacement',
                'primary_key' => 'id',
                'text_property' => 'name',
                'minimum_input_length' => 0,
                'page_limit' => 10,
                'allow_clear' => true,
                'delay' => 250,
                'cache' => true,
                'cache_timeout' => 60000, // if 'cache' is true
                'language' => 'fr',
                'placeholder' => 'Choisir ...',
                'required' =>true,
            ])
          
            ->add('save', SubmitType::class);



        $builder->addEventListener(
            FormEvents::PRE_SUBMIT, function (FormEvent $event) {

            $data = $event->getData();


            if ($data['creationdate'] != null) {
                $data['creationdate'] = \DateTime::createFromFormat('d.m.Y', $data['creationdate']);

                $event->setData($data);
            }

        }
        );
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA, function(FormEvent $event){
            $data = $event->getData();

            if ($data->getCreationdate() != null) {
                $data->setCreationdate($data->getCreationdate()->format('d.m.Y'));
            }

        }
        );



    }



    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Pointage::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sbcplatformbundle_pointage';
    }

}
