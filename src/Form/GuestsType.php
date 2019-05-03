<?php

namespace App\Form;

use App\Entity\Guests;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GuestsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nome'
            ])
            ->add('type', ChoiceType::class, [
                'choices' => ['Persona' => 1, 'Azienda' => 2]
        ])
            ->add('location', TextType::class, [
                'label' => 'Luogo'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Guests::class,
        ]);
    }
}
