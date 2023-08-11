<?php

namespace App\Form;

use App\Entity\Stage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sujet',TextType::class, [
                'attr'=>['required'=>'required']
            ])
            ->add('description',TextType::class, [
                'attr'=>['required'=>'required']
            ])
            ->add('technologies',TextType::class, [
                'attr'=>['required'=>'required']
            ])
            ->add('nomEncadreurExt')
            ->add('prenomEncadreurExt')
            ->add('numeroEncadreurExt')
            ->add('email')
            ->add('adresseEncadreurExt')
            ->add('validation')
            ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
