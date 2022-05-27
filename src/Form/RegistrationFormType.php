<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombreUsuario', TextType::Class, [
                'attr' => [
                    'placeholder' => 'Nombre de usuario',
                    'class' => 'form-control',
                    'autofocus' => 'autofocus'
                ]
            ])
            ->add('nombreCompleto', TextType::Class, [
                'attr' => [
                    'placeholder' => 'Nombre y apellidos',
                    'class' => 'form-control'
                ]
            ])
            ->add('fechaNac', DateType::class, [
                'input' => 'string',
                'format' => 'dd MM yyyy',
                'widget' => 'choice',
                'attr' => [
                    'class' => 'fechaNac'
                ],
                'placeholder' => [
                    'year' => 'Año', 'month' => 'Mes', 'day' => 'Día',
                ],
                'years' => range(1920,date('Y'))
            ])
            ->add('email', EmailType::Class, [
                'attr' => [
                    'placeholder' => 'Correo electrónico',
                    'class' => 'form-control'
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'placeholder' => 'Contraseña',
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Introduce una contraseña',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Tu contraseña debe tener al menos {{ limit }} caracteres',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                    
                ],
            ])
            ->add('plainPassword2', PasswordType::class, [
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'placeholder' => 'Repite la contraseña',
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Introduce una contraseña',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Tu contraseña debe tener al menos {{ limit }} caracteres',
                        'max' => 4096,
                    ]),
                    
                ],
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
