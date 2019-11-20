<?php


namespace App\Form\Type\Objects;


use App\Entity\ObjectCategory;
use FM\ElfinderBundle\Form\Type\ElFinderType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',
                TextType::class,
                [
                    'label' => 'Name',
                    'attr' => array(
                        'class' => "my_menu_name",
                    ),
                    'help' => 'The name of the category.'
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

            ->add('description',
                TextareaType::class,
                [
                    'label' => 'Description',
                    'attr'=>array(
                        'class' => 'rf-richtext',
                    ),
                    'required'=>false,
                    'help' => 'A brief description of the category'
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ObjectCategory::class,
        ]);
    }
}