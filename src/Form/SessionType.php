<?php

namespace App\Form;

use App\Entity\Chien;
use App\Entity\Session;
use App\Entity\Formation;
use App\Form\AteliersType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class SessionType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('formation', EntityType::class, [
        'label' => 'Nom de la Formation',
        'class' => Formation::class,
        'required'   => true,
        'choice_label' => 'nom',
      ])
      ->add('nbPlace', NumberType::class, [
        'required'   => true,
      ])
      ->add('chien', CollectionType::class, [
        'entry_type' => EntityType::class,
        'entry_options' => [
          'label' => "Choisir un chien :",
          'class' => Chien::class,
        ],
        'by_reference' => false,
        'label' => false,
        'required' => false,
        'allow_add' => true,
        'allow_delete' => true,
      ])
      ->add('dateDebut', DateType::class, [
        'label' => 'Date de début',
        'widget' => 'single_text',
      ])
      ->add('dateFin', DateType::class, [
        'label' => 'Date de fin',
        'widget' => 'single_text',
      ])
      ->add('programmers', CollectionType::class, [
        'label' => false,
        'entry_type' => AteliersType::class,
        'entry_options' => [
          'label' => "Module et durée : "
        ],
        'allow_add' => true,
        'allow_delete' => true,
        'by_reference' => false,
      ]);
    // not needed anymore
    // ->add('envoyer', SubmitType::class, [
    //   'attr' => ['class' => 'btn btn-outline-primary'],
    // ]);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => Session::class,
    ]);
  }
}
