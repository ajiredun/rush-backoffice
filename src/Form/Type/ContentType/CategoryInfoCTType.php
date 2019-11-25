<?php


namespace App\Form\Type\ContentType;

use App\Entity\ObjectCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class CategoryInfoCTType extends BaseContentType
{
    protected function addFields(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category',
                EntityType::class,
                [
                    'label' => 'Category',
                    'attr'=>array(
                    ),
                    'required'=>false,
                    'class' => ObjectCategory::class,
                    'choice_label' => 'name',
                ]
            )
            ->remove('title')
        ;
    }
}