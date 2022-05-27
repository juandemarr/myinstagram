<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('foto', FileType::class, [
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
                'label' => 'Imágen:',
                'constraints' => [
                    new File([
                        'maxSize' => '10024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/jpg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Sube una imágen válida',
                    ])
                ],
            ])
            ->add('nombreUsuario', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'required' => true
            ])
            ->add('nombreCompleto', TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'required' => true
            ])
            ->add('descripcion', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'resize' => 'none'
                ],
                'required' => false
            ])
            ->add('fechaNac', DateType::class, [
                'input' => 'string',
                'format' => 'dd MM yyyy',
                'widget' => 'choice',
                'attr' => [
                    'class' => 'fechaNac'
                ],
                'years' => range(1920,date('Y')),
                'required' => true
            ])
            ->add('email', EmailType::Class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'required' => true
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
