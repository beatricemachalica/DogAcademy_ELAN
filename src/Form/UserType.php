<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('nom', TextType::class, [
        'label' => 'Nom',
        'required'   => true,
      ])
      ->add('prenom', TextType::class, [
        'label' => 'Prénom',
        'required'   => true,
      ])
      ->add('email', EmailType::class, [
        'label' => 'Adresse Mail',
        'required'   => true,
      ])
      ->add('roles', ChoiceType::class, [
        'choices'  => [
          'Admin' => "ROLE_ADMIN",
        ],
        'expanded' => true,
        'multiple' => true,
      ]);
    // ->add('plainPassword', RepeatedType::class, [
    //   'type' => PasswordType::class,
    //   'first_options' => [
    //     'label' => 'Mot de passe'
    //   ],
    //   'second_options' => [
    //     'label' => 'Répétez le mot de passe'
    //   ],
    //   'invalid_message' => 'Les mots de passe ne correspondent pas',
    //   'mapped' => false,
    //   'attr' => ['autocomplete' => 'new-password'],
    //   'constraints' => [
    //     new NotBlank([
    //       'message' => 'Please enter a password',
    //     ]),
    //     new Length([
    //       'min' => 6,
    //       'minMessage' => 'Your password should be at least {{ limit }} characters',
    //       'max' => 4096,
    //     ]),
    //   ],
    // ]);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => User::class,
    ]);
  }
}
