<?php

namespace App\Form\Type\ContentType;


use App\ContentType\HalfImageHalfTextCT;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use FM\ElfinderBundle\Form\Type\ElFinderType;

class CreateUserAccountCTType extends BaseContentType
{
    protected function addFields(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('autoplay', ChoiceType::class, [
                    'choices' => array(
                        'Yes' => true,
                        'No' => false
                    ),
                    'multiple' => false,
                    'expanded' => false,
                    'label' => "Auto Play the slider?",
                    'help' => "The slide will move by itself.",
                    'required' => false
                ]
            )
        ;
    }
}