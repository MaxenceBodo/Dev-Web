<?php

namespace App\Form;

use App\Entity\EventSearch;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lieux', TextType::class,[
                'required'=>false,
                'label'=>false,
                'attr'=>[
                    'placeholder'=>'Lieux'
                ]
            ])
            ->add('date', DateType::class,[
                'required'=>false,
                'label'=>false,
                'attr'=>[
                    'placeholder'=>'Date'
                ]
            ])
            ->add('type',ChoiceType::class,[
                'required'=>false,
                'choices'=>[
                    'Autre'=>'autre',
                    'Cinema'=>'cinema',
                    'Theatre'=>'theatre',
                    'Restaurant'=>'restaurant',
                    'Sport'=>'Sport',
                    'Sortie en montagne'=>'sortie en montagne',
                    'Activite aquatique'=>'Activite aquatique',
                ],
                'label'=>false,
                'attr'=>[
                    'placeholder'=>'Type'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EventSearch::class,
            'method'=>'get',
            'csrf_protection'=>false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
