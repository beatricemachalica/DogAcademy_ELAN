<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\Regex;

class PasswordUpdateType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('old_password', PasswordType::class, [
        'constraints' => [
          new NotBlank([
            'message' => 'Merci de renseigner un mot de passe',
          ]),
          new Length([
            'min' => 8,
            'minMessage' => 'Votre mot de passe doit contenir au moins 8 caractères',
            // max length allowed by Symfony for security reasons
            'max' => 32,
          ]),
        ],
        'label' => 'Ancien mot de passe'
      ])
      ->add('new_password', PasswordType::class, [
        'constraints' => [
          new NotBlank([
            'message' => 'Merci de renseigner un mot de passe',
          ]),
          new Length([
            'min' => 8,
            'minMessage' => 'Votre mot de passe doit contenir au moins 8 caractères',
            // max length allowed by Symfony for security reasons
            'max' => 32,
          ]),
        ],
        'label' => 'Nouveau mot de passe',
        'help' => 'Le nouveau mot de passe doit contenir au moins huit caractères, dont des lettres majuscules et minuscules, un chiffre et un symbole.',
      ])
      ->add('confirm_password', PasswordType::class, [
        'constraints' => [
          new NotBlank([
            'message' => 'Merci de renseigner un mot de passe',
          ]),
          new Length([
            'min' => 8,
            'minMessage' => 'Votre mot de passe doit contenir au moins 8 caractères',
            // max length allowed by Symfony for security reasons
            'max' => 32,
          ]),
        ],
        'label' => 'Confirmez le nouveau mot de passe'
      ])
      ->add('Valider', SubmitType::class);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      // 'data_class' => User::class,
    ]);
  }
}
