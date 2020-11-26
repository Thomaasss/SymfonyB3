<?php

namespace App\Form;

use App\Entity\Ride;
use App\Entity\Train;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('departure', TextType::class, [
            'attr' => [
                'class' => 'form-control'
            ]
        ])
        ->add('departureDateTime', DateTimeType::class, [
           'attr' => [
               'class' => 'form-control'
           ]
        ])
        ->add('arrival', TextType::class, [
           'attr' => [
               'class' => 'form-control'
           ]
        ])
        ->add('arrivalDateTime', DateTimeType::class, [
           'attr' => [
               'class' => 'form-control'
           ]
        ])
        ->add('train', EntityType::class, [
            'class' => Train::class,
            'choice_label' => 'title'
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ride::class,
        ]);
    }
}
