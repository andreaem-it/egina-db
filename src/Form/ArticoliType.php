<?php

namespace App\Form;

use App\Entity\Articoli;
use App\Entity\Guests;
use App\Entity\TipoArticoli;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticoliType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codice', TextType::class, [
                'label' => 'Codice'
            ])
            ->add('name', TextType::class, [
                'label' => 'Nome'
            ])
            ->add('type', EntityType::class, [
                'class' => TipoArticoli::class,
                'choice_label' => 'name',
                'placeholder' => 'Scegli categoria',
                'label' => 'Categoria',

            ])
            ->add('dotazioni', TextType::class, [
                'label' => 'Dotazioni',
                'attr' => [
                    'placeholder' => 'Es: Alimentatore, Borsa PC'
                    ]
            ])
            ->add('danni', TextType::class, [
                'label' => 'Danni visibili',
                'data' => 'Nessun danno visibile',
            ])
            ->add('descrizione', TextAreaType::class, [
                'label' => 'Descrizione',
                'attr' => [
                    'rows' => 8
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Articoli::class,
        ]);
    }
}
