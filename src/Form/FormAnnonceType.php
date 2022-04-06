<?php

namespace App\Form;

use App\Entity\TrtAnnonce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormAnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('mission')
            ->add('vous')
            ->add('ville')
            ->add('contrat')
            ->add('horaire')
            ->add('salaireAnnuel')
            ->add('valider')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TrtAnnonce::class,
        ]);
    }
}
