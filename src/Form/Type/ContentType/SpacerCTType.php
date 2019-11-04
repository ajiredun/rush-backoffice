<?php

namespace App\Form\Type\ContentType;


use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use FM\ElfinderBundle\Form\Type\ElFinderType;

class SpacerCTType extends BaseContentType
{
    protected function addFields(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('space',
                NumberType::class,
                [
                    'label' => 'Space between the two elements',
                    'required'=>false,
                ]
            )
        ;
    }
}