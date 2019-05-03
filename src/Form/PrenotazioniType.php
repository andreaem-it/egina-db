<?php

namespace App\Form;

use App\Entity\Articoli;
use App\Entity\Guests;
use App\Entity\Prenotazioni;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrenotazioniType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', EntityType::class, [
                'class' => Guests::class,
                'choice_label' => 'name',
                'choice_value' => 'id',
                'placeholder' => 'Scegli Utente',
                'label' => 'Utente',
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'attr' => ['class' => 'js-datepicker'],
                'label' => 'Data prenotazione'])
            ->add('motivation', TextType::class, [
                'label' => 'Motivazione'
            ])
            ->add('item', EntityType::class, [
                'class' => Articoli::class,
                'choice_label' => function ($articoli) { return $articoli->getCodice() . ' - ' . $articoli->getName(); },
                'choice_value' => 'id',
                'placeholder' => 'Scegli Articolo',
                'label' => 'Articolo'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Prenotazioni::class,
        ]);
    }
}
