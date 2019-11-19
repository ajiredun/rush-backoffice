<?php

namespace App\Form\Type\ContentType;


use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use FM\ElfinderBundle\Form\Type\ElFinderType;

class MediumDisplayCTType extends BaseContentType
{
    protected function addFields(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image01',
                ElFinderType::class,
                [
                    'instance'=>'gallery',
                    'label' => 'Image Left',
                    'enable'=>true ,
                    'attr'=>array(
                        'readOnly'=>'true',
                        'placeholder'=> 'Click To Choose',
                        'class' => 'disabled rf-media-form-type',
                        'required' => 'true'
                    )
                ]
            )
            ->add('image01Url',
                UrlType::class,
                [
                    'label' => 'Link for Image',
                    'attr' => array(
                        'class' => "",
                    ),
                    'required'=> false,
                    'help' => "Leave blank if you don't want the link to appear."
                ]
            )

            ->add('image02',
                ElFinderType::class,
                [
                    'instance'=>'gallery',
                    'label' => 'Image Right',
                    'enable'=>true ,
                    'attr'=>array(
                        'readOnly'=>'true',
                        'placeholder'=> 'Click To Choose',
                        'class' => 'disabled rf-media-form-type',
                        'required' => 'true'
                    )
                ]
            )
            ->add('image02Url',
                UrlType::class,
                [
                    'label' => 'Link for Image',
                    'attr' => array(
                        'class' => "",
                    ),
                    'required'=> false,
                    'help' => "Leave blank if you don't want the link to appear."
                ]
            )
            ->remove('padding')
            ->remove('title')
        ;
    }
}