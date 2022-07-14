<?php

namespace App\Form;

use App\Entity\CategoryFilter;
use App\Entity\CategoryFilterItem;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryFilterItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('value')
            ->add('categoryFilter', EntityType::class, [
                'class' => CategoryFilter::class
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CategoryFilterItem::class,
        ]);
    }
}
