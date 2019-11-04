<?php

namespace App\Form\Type\ContentType;


use App\ContentType\HalfImageHalfTextCT;
use App\ContentType\OneThirdImageTwoThirdTextCT;
use App\ContentType\TwoThirdImageOneThirdTextCT;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use FM\ElfinderBundle\Form\Type\ElFinderType;

class TwoThirdImageOneThirdTextCTType extends BaseContentType
{
    protected function addFields(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('side', ChoiceType::class, [
                    'choices' => array(
                        'Image on left' => TwoThirdImageOneThirdTextCT::IMAGE_ON_LEFT,
                        'Image on right' => TwoThirdImageOneThirdTextCT::IMAGE_ON_RIGHT
                    ),
                    'multiple' => false,
                    'expanded' => true,
                    'label' => "Where do you want to put the image?"
                ]
            )
            ->add('image',
                ElFinderType::class,
                [
                    'instance'=>'gallery',
                    'label' => 'Image',
                    'enable'=>true ,
                    'attr'=>array(
                        'readOnly'=>'true',
                        'placeholder'=> 'Click To Choose',
                        'class' => 'disabled rf-media-form-type',
                        'required' => 'true'
                    )
                ]
            )
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

            ->add('background',
                ColorType::class,
                [
                    'label' => 'Background colour',
                    'attr'=>array(
                        'class' => 'rf-bg',
                    ),
                    'empty_data' => '#f8f8f8',
                    'required'=>false,
                ]
            )
        ;
    }
}