<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints as Assert ;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('period', ChoiceType::class, array(
                'label' => 'Durée',
                'choices' => array(
                    'Journée' => 1,
                    'Demi-journée' => 0.5,
                ),
            ))
            ->add('dateVisit', DateType::class, array(
                'label' => 'Date de visite',
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker'],
                'constraints' => [ new Assert\Range (array(
                        'min' => '-1 day',
                        'max' => '+2 months',
                        'minMessage' => "La date est passée.",
                        'maxMessage' => " Trop tôt pour réserver ",
                ))],
                'format' => 'dd/MM/yyyy',
                'html5' => false,
            ))
            ->add('visitors', CollectionType::class, array(

                'label' =>' ',
                'by_reference' => false,
                'entry_type' => VisitorType::class,
                'allow_add' => true,
                'allow_delete' => true
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Valider'
            ))
            ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Ticket'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_ticket';
    }


}
