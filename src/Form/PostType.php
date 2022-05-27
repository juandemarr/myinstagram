<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
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
            'data_class' => null,
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
            ->add('descripcion', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Descripción',
                    'resize' => 'none'
                ],
                'required' => false,
                'label_attr' => ['class' => 'desc']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
