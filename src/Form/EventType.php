<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Core\User\UserInterface;

class EventType extends AbstractType
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
            ->add('lieux',TextType::class, [
                'required' => true
            ])
            ->add('date',DateType::class, [
                'required' => true,
                'years'=>range(2021,2025),
                'data'=> new \DateTime()
            ])
            ->add('description',TextType::class, ['required' => true])
            
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
