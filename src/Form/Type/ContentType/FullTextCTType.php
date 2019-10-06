<?php

namespace App\Form\Type\ContentType;


use App\ContentType\HalfImageHalfTextCT;
use App\ContentType\OneThirdImageTwoThirdTextCT;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use FM\ElfinderBundle\Form\Type\ElFinderType;

class FullTextCTType extends BaseContentType
{
    protected function addFields(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text',
                TextareaType::class,
                [
                    'label' => 'Contents',
                    'attr'=>array(
                        'class' => 'rf-richtext',
                    ),
                    'required'=>false,
                ]
            )
        ;
    }
}