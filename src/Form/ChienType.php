<?php

namespace App\Form;

use App\Entity\Chien;
use App\Entity\Maitre;
use App\Entity\Session;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ChienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom du chien',
                'required'   => true,
            ])
            ->add('maitre', EntityType::class, [
                'label' => 'Maître du chien',
                'class' => Maitre::class,
                'required'   => true,
                'choice_label' => 'nom',
            ])
            // message d'erreur ici => problème avec l'entité
            // ->add('sessions', EntityType::class, [
            //     'label' => 'Session de Formation',
            //     'class' => Session::class,
            //     'required'   => true,
            //     'choice_label' => 'formation',
            // ])
            ->add('envoyer', SubmitType::class, [
                'attr' => ['class' => 'btn btn-outline-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Chien::class,
        ]);
    }
}
