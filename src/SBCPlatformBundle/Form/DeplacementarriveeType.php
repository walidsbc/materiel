<?php


namespace SBCPlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;


use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class DeplacementarriveeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->remove('creationdate')
            ->remove('materiel')
            ->remove('transmitter')
            ->remove('deliverer')
            ->remove('currentlocation')
            ->remove('destinatedlocation')
            ->remove('deliveredby')
            ->remove('receiver')
            ->add('currentlocation', Select2EntityType::class, [
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
                'disabled' => true,

            ])
            ->add('materiel', Select2EntityType::class, [
                'multiple' => false,
                'remote_route' => 'materiel_liste_for_select2',
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
                'disabled' => true,
            ])
            ->add('transmitter', Select2EntityType::class, [
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
                'disabled' => true,
            ])
            ->add('deliverer', Select2EntityType::class, [
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
                'disabled' => true,
            ])
            ->add('destinatedlocation', Select2EntityType::class, [
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
                'disabled' => true,
            ])
            ->add('receiver', Select2EntityType::class, [
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
                'required' => true,
            ])
            ->add('deliveredby', Select2EntityType::class, [
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
                'required' => true,
            ]);


    }


    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sbcplatformbundle_deplacement_edit';
    }

    public function getParent()
    {
        return DeplacementType::class;
    }
}