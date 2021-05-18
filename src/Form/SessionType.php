<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Formation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
      ->add('dateDebut', DateType::class, [
        'label' => 'Date de début',
        'widget' => 'single_text',
      ])
      ->add('dateFin', DateType::class, [
        'label' => 'Date de fin',
        'widget' => 'single_text',
      ])
      ->add('envoyer', SubmitType::class, [
        'attr' => ['class' => 'btn btn-outline-primary'],
      ]);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => Session::class,
    ]);
  }
}
