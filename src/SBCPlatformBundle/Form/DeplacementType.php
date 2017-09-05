<?php

namespace SBCPlatformBundle\Form;

use SBCPlatformBundle\Entity\Deplacement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;


class DeplacementType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reference')
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
                'required' => true,
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
                'required' => true,
            ])
            ->add('departuredate', TextType::class)
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
                'required' => true,
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
                'required' => true,
            ])
            ->add('arriveddate', TextType::class)
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

            ])
            ->add('status', ChoiceType::class, array(
                'choices' => array(
                    'En départ' => 'En départ', 'Arrivé' => 'Arrivé'),
                'expanded' => true,
                'choices_as_values' => true,
                'multiple' => false

            ))
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
                'required' => true,
            ]);

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT, function (FormEvent $event) {

            $data = $event->getData();

            if ($data['status'] == "En départ") {
                $data['arriveddate'] = null;
                $data['receiver'] = null;
                $data['deliveredby'] = null;
                $event->setData($data);
            }

//            if ($data['status'] == "Arrivé") {
//                $data['departuredate'] = new \DateTime($data['departuredate']);
//
//                $event->setData($data);
//            }


            if ($data['arriveddate'] != null) {
                $data['arriveddate'] = \DateTime::createFromFormat('d.m.Y', $data['arriveddate']);

                $event->setData($data);
            }
            if ($data['departuredate'] != null) {
                $data['departuredate'] = \DateTime::createFromFormat('d.m.Y', $data['departuredate']);


                $event->setData($data);
            }


        }
        )
            ->addEventListener(
                FormEvents::PRE_SET_DATA, function(FormEvent $event){
                $data = $event->getData();

                if ($data->getDeparturedate() != null) {
                    $data->setDeparturedate($data->getDeparturedate()->format('d.m.Y'));
                }
            }
            )
            ->add('status', ChoiceType::class, array(
                'choices' => array(
                    'En départ' => 'En départ', 'Arrivé' => 'Arrivé'),
                'expanded' => true,
                'choices_as_values' => true,
                'multiple' => false
            ))
            ->add('save', SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Deplacement::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sbcplatformbundle_deplacement';
    }

}
