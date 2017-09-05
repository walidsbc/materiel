<?php

namespace SBCPlatformBundle\Form;


use SBCPlatformBundle\Entity\Materiel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class MaterielType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('reference')
            ->add('registration')
            ->add('serialnumber')
            ->add('fournisseur', null, array(
                'attr' => array(
                    'class' => 'kendoComboBox select',
                    'style' => 'width:100%',
                    'required' => true
                )
            ))
            ->add('buydate', TextType::class)
            ->add('buyprice')
            ->add('lifetime')
            ->add('unitcost', HiddenType::class)
//            ->add('factureFile', \Symfony\Component\Form\Extension\Core\Type\FileType::class, array(
//                'required' => true,
//                ))
            ->add('files', CollectionType::class, array(
                'entry_type' => FileType::class,
                'allow_add' => true,
                'by_reference' =>false

            ))
            
            ->add('planifications', CollectionType::class, array(
                'entry_type' => PlanificationPreventionSansMaterielType::class,
                'allow_add' => true,
                'required' => false,
                'by_reference' =>false,
                'attr'=> array('class' =>'typeinterventions-selector')

            ))
            ->add('save', SubmitType::class);

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT, function (FormEvent $event) {

            $data = $event->getData();

            $data['unitcost'] = $data['buyprice'] / $data['lifetime'];
            $event->setData($data);

            if ($data['buydate'] != null) {
                $data['buydate'] = \DateTime::createFromFormat('d.m.Y', $data['buydate']);
                
                $event->setData($data);
            }
        }
        );
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $data = $event->getData();

            if ($data->getBuydate() != null) {
                $data->setBuydate($data->getBuydate()->format('d.m.Y'));
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
            'data_class' => Materiel::class,
            'allow_extra_fields' => true
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sbcplatformbundle_materiel';
    }


}
