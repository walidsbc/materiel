<?php

namespace SBCPlatformBundle\Form;

use SBCPlatformBundle\Entity\Chantier;
use SBCPlatformBundle\Entity\MyDate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ChantierType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('code')
            ->add('status', ChoiceType::class, array(
                'choices' => array('En préparation' => 'En préparation', 'En cours' => 'En cours', 'Cloturé' => 'Cloturé'),
                'expanded' => true,
                'multiple' => false,
                'choices_as_values' => true
            ))
            ->add('location')
            ->add('begindate', TextType::class)
            ->add('finishdate', TextType::class)
            ->add('save', SubmitType::class)
            
            ->addEventListener(
                FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $data = $event->getData();

                if ($data->getBegindate() != null) {
                    $data->setBegindate($data->getBegindate()->format('d.m.Y'));
                }
                if ($data->getFinishdate() != null) {
                    $data->setFinishdate($data->getFinishdate()->format('d.m.Y'));
                }
            }
            )
            ->addEventListener(
                FormEvents::PRE_SUBMIT, function (FormEvent $event) {

                $data = $event->getData();

                if ($data['status'] == "En cours") {
                    $data['finishdate'] = null;
                    $event->setData($data);
                }
                if ($data['status'] == "En préparation") {
                    $data['finishdate'] = null;
                    $data['begindate'] = null;
                    $event->setData($data);
                }
                if ($data['begindate'] != null) {
                    $data['begindate'] = MyDate::stringToDate($data['begindate']);

                    $event->setData($data);
                }

                if ($data['finishdate'] != null) {
                    $data['finishdate'] = MyDate::stringToDate($data['finishdate']);

                    $event->setData($data);
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
            'data_class' => Chantier::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sbcplatformbundle_chantier';
    }

}
