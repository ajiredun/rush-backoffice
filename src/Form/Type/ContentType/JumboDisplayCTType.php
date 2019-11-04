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

class JumboDisplayCTType extends BaseContentType
{
    protected function addFields(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image01',
                ElFinderType::class,
                [
                    'instance'=>'gallery',
                    'label' => 'Left Image',
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
            ->add('image01UrlText',
                TextType::class,
                [
                    'label' => 'Text for Link',
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
                    'label' => 'Right Image',
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
            ->add('image02UrlText',
                TextType::class,
                [
                    'label' => 'Text for Link',
                    'attr' => array(
                        'class' => "",
                    ),
                    'required'=> false,
                    'help' => "Leave blank if you don't want the link to appear."
                ]
            )
            ->add('adv_width',
                TextType::class,
                [
                    'label' => 'ADVANCED: The maximum width of each image',
                    'attr' => array(
                        'class' => "",
                    ),
                    'required'=> false,
                    'help' => "This will crop the elements who are bigger than the width mentionned (in pixels)"
                ]
            )
            ->add('adv_height',
                TextType::class,
                [
                    'label' => 'ADVANCED: Height of each picture',
                    'attr' => array(
                        'class' => "",
                    ),
                    'required'=> false,
                    'help' => "This will crop the elements who are bigger than the height mentionned (in pixels)"
                ]
            )
        ;
    }
}