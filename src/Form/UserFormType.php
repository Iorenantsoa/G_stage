<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class, [
                'attr'=>['class'=>'form-control','style'=>'border:0;border-bottom:2px solid black ','placeholder'=>'type your name']
            ])
            ->add('firstname',TextType::class, [
                'attr'=>['class'=>'form-control','style'=>'border:0;border-bottom:2px solid black ','placeholder'=>'type your firstname']
            ])
            ->add('email',EmailType::class, [
                'attr'=>['class'=>'form-control','style'=>'border:0;border-bottom:2px solid black ','placeholder'=>'type your email']
            ])
            ->add('image', FileType::class, [
                'label' => 'Image',
                'attr'=>['class'=>'form-control','style'=>'border:0;border-bottom:2px solid black '],
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '10240k',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/png',
                            'image/JPG',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image ',
                    ])
                ],
            ])
            
            ->add('Update', SubmitType::class,[
                'attr'=>['class'=>'form-control btn btn-primary mt-3']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
