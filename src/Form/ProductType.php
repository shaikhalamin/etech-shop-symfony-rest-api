<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotNull;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotNull(
                        [
                            'message' => "Product name is requred"
                        ]
                    ),
                ]
            ])
            ->add('details', TextType::class, [
                'constraints' => [
                    new NotNull(
                        [
                            'message' => "Product details is requred"
                        ]
                    ),
                ]
            ])
            ->add('price', TextType::class, [
                'constraints' => [
                    new NotNull(
                        [
                            'message' => "Product price is requred"
                        ]
                    ),
                ]
            ])
            ->add('quantity', TextType::class, [
                'constraints' => [
                    new NotNull(
                        [
                            'message' => "Product quantity is requred"
                        ]
                    ),
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'constraints' => [
                    new NotNull(
                        [
                            'message' => "Product category is requred"
                        ]
                    ),
                ]
            ])
            ->add('image', FileType::class, [
                'constraints' => [
                    new NotNull(
                        [
                            'message' => "Product image is requred"
                        ]
                    ),
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
            ->add('is_featured', CheckboxType::class)
            ->add('features', CollectionType::class, [
                'constraints' => [
                    new NotNull(
                        [
                            'message' => "Product features is requred"
                        ]
                    ),
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
