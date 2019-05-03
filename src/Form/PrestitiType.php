<?php

namespace App\Form;

use App\Entity\Guests;
use App\Entity\Prestiti;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrestitiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('guest', EntityType::class, [
                'class' => Guests::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'choice_label' => function ($guests) {
                    return $guests->getName();
                },
                'choice_value' => 'id',
                'placeholder' => 'Scegli Utente',
                'label' => 'Utente',
            ])
            ->add('location', TextType::class, [
                'label' => 'Dove si trova'
            ])
            ->add('motivation', TextType::class, [
                'label' => 'Motivazione'
            ])
            ->add('dateBack', DateTimeType::class, [
                'html5' => true,
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker'],
                'label' => 'Data rientro prevista',
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'In Magazzino' => '1',
                    'Fuori Magazzino' => '0'
                ],
                'label' => 'Stato'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Prestiti::class,
        ]);
    }
}
