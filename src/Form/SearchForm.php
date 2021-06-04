<?php

namespace App\Form;

use App\Data\SearchData;
use App\Entity\Session;
use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SearchForm extends AbstractType
{

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('q', TextType::class, [
        'label' => false,
        'required' => false,
        'attr' => [
          'placeholder' => 'Rechercher'
        ]
      ])
      ->add('formations', EntityType::class, [
        'label' => false,
        'required' => false,
        'class' => Session::class,
        'expanded' => true,
        'multiple' => true
      ])
      // ->add('min', DateType::class, [
      //   'label' => false,
      //   'required' => false,
      //   'format' => 'yyyy-MM-dd',
      //   'attr' => [
      //     'placeholder' => 'Date Min'
      //   ]
      // ])
      // ->add('max', DateType::class, [
      //   'label' => false,
      //   'required' => false,
      //   'format' => 'yyyy-MM-dd',
      //   'attr' => [
      //     'placeholder' => 'Date Max'
      //   ]
      // ])
    ;
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => SearchData::class,
      'method' => 'GET',
      'csrf_protection' => false
    ]);
  }

  public function getBlockPrefix()
  {
    return '';
  }
}
