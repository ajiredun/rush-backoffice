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

class SliderThumbnailCTType extends BaseContentType
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
            ->add('autoplayTimeout',
                TextType::class,
                [
                    'label' => 'Timeout',
                    'attr' => array(
                        'class' => "",
                    ),
                    'required'=> false,
                    'help' => "The number of miliseconds to wait before moving to the next slide"
                ]
            )
            ->add('slideQtyInMobile',
                TextType::class,
                [
                    'label' => 'Qty of slides in mobile',
                    'attr' => array(
                        'class' => "",
                    ),
                    'required'=> false,
                    'help' => "The number of slides you want to see at once."
                ]
            )
            ->add('slideQtyInTablet',
                TextType::class,
                [
                    'label' => 'Qty of slides in tablet',
                    'attr' => array(
                        'class' => "",
                    ),
                    'required'=> false,
                    'help' => "The number of slides you want to see at once."
                ]
            )
            ->add('slideQtyInDesktop',
                TextType::class,
                [
                    'label' => 'Qty of slides in desktop',
                    'attr' => array(
                        'class' => "",
                    ),
                    'required'=> false,
                    'help' => "The number of slides you want to see at once."
                ]
            )
            ->add('image01',
                ElFinderType::class,
                [
                    'instance'=>'gallery',
                    'label' => 'Image 01',
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
                    'label' => 'Url for Image',
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
                    'label' => 'Url Text for Image',
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
                    'label' => 'Image 02',
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
                    'label' => 'Url for Image',
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
                    'label' => 'Url Text for Image',
                    'attr' => array(
                        'class' => "",
                    ),
                    'required'=> false,
                    'help' => "Leave blank if you don't want the link to appear."
                ]
            )
            ->add('image03',
                ElFinderType::class,
                [
                    'instance'=>'gallery',
                    'label' => 'Image 03',
                    'enable'=>true ,
                    'attr'=>array(
                        'readOnly'=>'true',
                        'placeholder'=> 'Click To Choose',
                        'class' => 'disabled rf-media-form-type'
                    )
                ]
            )
            ->add('image03Url',
                UrlType::class,
                [
                    'label' => 'Url for Image',
                    'attr' => array(
                        'class' => "",
                    ),
                    'required'=> false,
                    'help' => "Leave blank if you don't want the link to appear."
                ]
            )
            ->add('image03UrlText',
                TextType::class,
                [
                    'label' => 'Url Text for Image',
                    'attr' => array(
                        'class' => "",
                    ),
                    'required'=> false,
                    'help' => "Leave blank if you don't want the link to appear."
                ]
            )
            ->add('image04',
                ElFinderType::class,
                [
                    'instance'=>'gallery',
                    'label' => 'Image 04',
                    'enable'=>true ,
                    'attr'=>array(
                        'readOnly'=>'true',
                        'placeholder'=> 'Click To Choose',
                        'class' => 'disabled rf-media-form-type'
                    )
                ]
            )
            ->add('image04Url',
                UrlType::class,
                [
                    'label' => 'Url for Image',
                    'attr' => array(
                        'class' => "",
                    ),
                    'required'=> false,
                    'help' => "Leave blank if you don't want the link to appear."
                ]
            )
            ->add('image04UrlText',
                TextType::class,
                [
                    'label' => 'Url Text for Image',
                    'attr' => array(
                        'class' => "",
                    ),
                    'required'=> false,
                    'help' => "Leave blank if you don't want the link to appear."
                ]
            )
            ->add('image05',
                ElFinderType::class,
                [
                    'instance'=>'gallery',
                    'label' => 'Image 05',
                    'enable'=>true ,
                    'attr'=>array(
                        'readOnly'=>'true',
                        'placeholder'=> 'Click To Choose',
                        'class' => 'disabled rf-media-form-type'
                    )
                ]
            )
            ->add('image05Url',
                UrlType::class,
                [
                    'label' => 'Url for Image',
                    'attr' => array(
                        'class' => "",
                    ),
                    'required'=> false,
                    'help' => "Leave blank if you don't want the link to appear."
                ]
            )
            ->add('image05UrlText',
                TextType::class,
                [
                    'label' => 'Url Text for Image',
                    'attr' => array(
                        'class' => "",
                    ),
                    'required'=> false,
                    'help' => "Leave blank if you don't want the link to appear."
                ]
            )
            ->add('image06',
                ElFinderType::class,
                [
                    'instance'=>'gallery',
                    'label' => 'Image 06',
                    'enable'=>true ,
                    'attr'=>array(
                        'readOnly'=>'true',
                        'placeholder'=> 'Click To Choose',
                        'class' => 'disabled rf-media-form-type'
                    )
                ]
            )
            ->add('image06Url',
                UrlType::class,
                [
                    'label' => 'Url for Image',
                    'attr' => array(
                        'class' => "",
                    ),
                    'required'=> false,
                    'help' => "Leave blank if you don't want the link to appear."
                ]
            )
            ->add('image06UrlText',
                TextType::class,
                [
                    'label' => 'Url Text for Image',
                    'attr' => array(
                        'class' => "",
                    ),
                    'required'=> false,
                    'help' => "Leave blank if you don't want the link to appear."
                ]
            )
            ->add('image07',
                ElFinderType::class,
                [
                    'instance'=>'gallery',
                    'label' => 'Image 07',
                    'enable'=>true ,
                    'attr'=>array(
                        'readOnly'=>'true',
                        'placeholder'=> 'Click To Choose',
                        'class' => 'disabled rf-media-form-type'
                    )
                ]
            )
            ->add('image07Url',
                UrlType::class,
                [
                    'label' => 'Url for Image',
                    'attr' => array(
                        'class' => "",
                    ),
                    'required'=> false,
                    'help' => "Leave blank if you don't want the link to appear."
                ]
            )
            ->add('image07UrlText',
                TextType::class,
                [
                    'label' => 'Url Text for Image',
                    'attr' => array(
                        'class' => "",
                    ),
                    'required'=> false,
                    'help' => "Leave blank if you don't want the link to appear."
                ]
            )
            ->add('image08',
                ElFinderType::class,
                [
                    'instance'=>'gallery',
                    'label' => 'Image 08',
                    'enable'=>true ,
                    'attr'=>array(
                        'readOnly'=>'true',
                        'placeholder'=> 'Click To Choose',
                        'class' => 'disabled rf-media-form-type'
                    )
                ]
            )
            ->add('image08Url',
                UrlType::class,
                [
                    'label' => 'Url for Image',
                    'attr' => array(
                        'class' => "",
                    ),
                    'required'=> false,
                    'help' => "Leave blank if you don't want the link to appear."
                ]
            )
            ->add('image08UrlText',
                TextType::class,
                [
                    'label' => 'Url Text for Image',
                    'attr' => array(
                        'class' => "",
                    ),
                    'required'=> false,
                    'help' => "Leave blank if you don't want the link to appear."
                ]
            )
            ->add('image09',
                ElFinderType::class,
                [
                    'instance'=>'gallery',
                    'label' => 'Image 09',
                    'enable'=>true ,
                    'attr'=>array(
                        'readOnly'=>'true',
                        'placeholder'=> 'Click To Choose',
                        'class' => 'disabled rf-media-form-type'
                    )
                ]
            )
            ->add('image09Url',
                UrlType::class,
                [
                    'label' => 'Url for Image',
                    'attr' => array(
                        'class' => "",
                    ),
                    'required'=> false,
                    'help' => "Leave blank if you don't want the link to appear."
                ]
            )
            ->add('image09UrlText',
                TextType::class,
                [
                    'label' => 'Url Text for Image',
                    'attr' => array(
                        'class' => "",
                    ),
                    'required'=> false,
                    'help' => "Leave blank if you don't want the link to appear."
                ]
            )
            ->add('image10',
                ElFinderType::class,
                [
                    'instance'=>'gallery',
                    'label' => 'Image 10',
                    'enable'=>true ,
                    'attr'=>array(
                        'readOnly'=>'true',
                        'placeholder'=> 'Click To Choose',
                        'class' => 'disabled rf-media-form-type'
                    )
                ]
            )
            ->add('image10Url',
                UrlType::class,
                [
                    'label' => 'Url for Image',
                    'attr' => array(
                        'class' => "",
                    ),
                    'required'=> false,
                    'help' => "Leave blank if you don't want the link to appear."
                ]
            )
            ->add('image10UrlText',
                TextType::class,
                [
                    'label' => 'Url Text for Image',
                    'attr' => array(
                        'class' => "",
                    ),
                    'required'=> false,
                    'help' => "Leave blank if you don't want the link to appear."
                ]
            )
            ->add('adv_height',
                TextType::class,
                [
                    'label' => 'ADVANCED: Height of the slider',
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