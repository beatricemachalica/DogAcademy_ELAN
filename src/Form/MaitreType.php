<?php

namespace App\Form;

use App\Entity\Maitre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MaitreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'required'   => true,
            ])
            ->add('prenom', TextType::class, [
                'required'   => true,
            ])
            ->add('mail', EmailType::class, [
                'required' => true,
            ])
            ->add('dateNaissance', DateType::class, [
                'required' => true,
                'widget' => 'single_text',
            ])
            ->add('ville', TextType::class, [
                'required'   => true,
            ])
            ->add('telephone', TelType::class, [
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Maitre::class,
        ]);
    }
}
