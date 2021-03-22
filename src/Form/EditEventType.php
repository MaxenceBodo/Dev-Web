<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EditEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class, ['required' => true])
            ->add('type',ChoiceType::class, [
                'required' => true,
                'choices'=>[
                    'Autre'=>'autre',
                    'Cinema'=>'cinema',
                    'Theatre'=>'theatre',
                    'Restaurant'=>'restaurant',
                    'Sport'=>'Sport',
                    'Sortie en montagne'=>'sortie en montagne',
                    'Activite aquatique'=>'Activite aquatique',
                ],
            ])
            ->add('lieux',TextType::class, ['required' => true])
            ->add('date',DateType::class, [
                'required' => true,
                'data'=> new \DateTime()
            ])
            ->add('description',TextType::class, ['required' => true])
            ->add('createur',EntityType::class,[
                'class'=>User::class,
                'choice_label'=>'email',
                'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
