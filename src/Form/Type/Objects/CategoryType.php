<?php


namespace App\Form\Type\Objects;


use App\Entity\ObjectCategory;
use App\Enums\Boolean;
use FM\ElfinderBundle\Form\Type\ElFinderType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
                        'class' => "my_category_name",
                        'autofocus' => "autofocus"
                    ),
                    'help' => 'The name of the category.'
                ]
            )
            ->add('slug',
                TextType::class,
                [
                    'label' => 'Category Page Route',
                    'attr' => array(
                        'class' => "my_category_route",
                    ),
                    'help' => 'This should be same as the page URL for this category.'
                ]
            )
            ->add('online',
                ChoiceType::class,
                [
                    'label' => 'Display in sub-categories list?',
                    'choices' => Boolean::getChoices(),
                    'multiple' => false,
                    'expanded' => true,
                    'help' => 'This will display this category in the front office'
                ]
            )
            ->add('category',
                EntityType::class,
                [
                    'label' => 'Parent',
                    'attr'=>array(
                    ),
                    'required'=>false,
                    'class' => ObjectCategory::class,
                    'choice_label' => 'name',
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
                    ),
                    'required' => true
                ]
            )

            ->add('description',
                TextareaType::class,
                [
                    'label' => 'SEO Description',
                    'attr'=>array(
                        'class' => 'rf-richtext',
                    ),
                    'required'=>false,
                    'help' => 'A brief description of the category for SEO'
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