<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type as FormType;
use Symfony\Component\Validator\Constraints\NotNull;

class Data extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('items', FormType\TextType::class, [
                'constraints' => [
                    new NotNull(
                        [
                            'message' => "Product image is requred"
                        ]
                    ),
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
    }
}
