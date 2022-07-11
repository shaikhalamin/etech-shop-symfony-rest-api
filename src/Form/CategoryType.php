<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotNull;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotNull(
                        [
                            'message' => "Category name is requred"
                        ]
                    ),
                ]
            ])
            ->add('slug', TextType::class, [
                'constraints' => [
                    new NotNull(
                        [
                            'message' => "Category slug is required"
                        ]
                    ),
                ]
            ])
            ->add('image', FileType::class, [
                // 'mapped' => false,
                'constraints' => [
                new File(
                    [
                        // 'maxSize' => '8048k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/webp'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image file',
                    ]
                )
                ]
            ])
            // ->add('created_at', DateTimeType::class, [
            //     'widget' => 'single_text',
            //     'constraints' => [
            //         new NotNull(),
            //     ]
            // ])
            // ->add('updated_at')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
            // 'csrf_protection' => false,
        ]);
    }
}
