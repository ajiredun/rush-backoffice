<?php


namespace App\Form\Type\Objects;


use App\Entity\ObjectCategory;
use App\Entity\ObjectProduct;
use App\Enums\Boolean;
use FM\ElfinderBundle\Form\Type\ElFinderType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProductType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',
                TextType::class,
                [
                    'label' => 'Name',
                    'attr' => [],
                    'help' => 'The name of the product.'
                ]
            )

            ->add('referenceNo',
                TextType::class,
                [
                    'label' => 'Reference No.',
                    'attr' => [],
                    'help' => 'A unique reference number of the product'
                ]
            )

            ->add('category',
                EntityType::class,
                [
                    'label' => 'Category',
                    'attr'=>array(
                    ),
                    'required'=>true,
                    'help' => 'Choose a category for this product',
                    'class' => ObjectCategory::class,
                    'choice_label' => 'name',
                ]
            )

            ->add('display',
                ChoiceType::class,
                [
                    'label' => 'Show in Front Office ?',
                    'choices' => Boolean::getChoices(),
                    'multiple' => false,
                    'expanded' => true,
                    'help' => 'This will display the product in front office.'
                ]
            )

            /*->add('sellOnline',
                ChoiceType::class,
                [
                    'label' => 'Sell Online ?',
                    'choices' => Boolean::getChoices(),
                    'multiple' => false,
                    'expanded' => true,
                    'help' => 'This will display the ADD TO CART'
                ]
            )*/

            ->add('priceAsFrom',
                ChoiceType::class,
                [
                    'label' => 'Show "as from" before the price ?',
                    'choices' => Boolean::getChoices(),
                    'multiple' => false,
                    'expanded' => true,
                ]
            )

            ->add('price',
                TextType::class,
                [
                    'label' => 'Price (Rs)',
                    'attr' => [],
                    'help' => 'The price / starting price of the product'
                ]
            )

            ->add('image',
                ElFinderType::class,
                [
                    'instance'=>'gallery',
                    'label' => 'Main Image',
                    'enable'=>true ,
                    'attr'=>array(
                        'readOnly'=>'true',
                        'placeholder'=> 'Click To Choose',
                        'class' => 'disabled rf-media-form-type',
                        'required' => 'true'
                    ),
                    'help' => 'The main image of the product. (High Resolution)'
                ]
            )

            ->add('thumbnail',
                ElFinderType::class,
                [
                    'instance'=>'gallery',
                    'label' => 'Thumbnail',
                    'enable'=>true ,
                    'attr'=>array(
                        'readOnly'=>'true',
                        'placeholder'=> 'Click To Choose',
                        'class' => 'disabled rf-media-form-type',
                        'required' => 'true'
                    ),
                    'help' => 'The image of the product that will be used in the lists, invoice,...'
                ]
            )

            ->add('image02',
                ElFinderType::class,
                [
                    'instance'=>'gallery',
                    'label' => 'other images',
                    'enable'=>true ,
                    'attr'=>array(
                        'readOnly'=>'true',
                        'placeholder'=> 'Click To Choose',
                        'class' => 'disabled rf-media-form-type',
                        'required' => 'true'
                    ),
                ]
            )

            ->add('image03',
                ElFinderType::class,
                [
                    'instance'=>'gallery',
                    'label' => 'other images',
                    'enable'=>true ,
                    'attr'=>array(
                        'readOnly'=>'true',
                        'placeholder'=> 'Click To Choose',
                        'class' => 'disabled rf-media-form-type',
                        'required' => 'true'
                    ),
                ]
            )

            ->add('image04',
                ElFinderType::class,
                [
                    'instance'=>'gallery',
                    'label' => 'other images',
                    'enable'=>true ,
                    'attr'=>array(
                        'readOnly'=>'true',
                        'placeholder'=> 'Click To Choose',
                        'class' => 'disabled rf-media-form-type',
                        'required' => 'true'
                    ),
                ]
            )

            ->add('image05',
                ElFinderType::class,
                [
                    'instance'=>'gallery',
                    'label' => 'other images',
                    'enable'=>true ,
                    'attr'=>array(
                        'readOnly'=>'true',
                        'placeholder'=> 'Click To Choose',
                        'class' => 'disabled rf-media-form-type',
                        'required' => 'true'
                    ),
                ]
            )

            ->add('image06',
                ElFinderType::class,
                [
                    'instance'=>'gallery',
                    'label' => 'other images',
                    'enable'=>true ,
                    'attr'=>array(
                        'readOnly'=>'true',
                        'placeholder'=> 'Click To Choose',
                        'class' => 'disabled rf-media-form-type',
                        'required' => 'true'
                    ),
                ]
            )

            ->add('image07',
                ElFinderType::class,
                [
                    'instance'=>'gallery',
                    'label' => 'other images',
                    'enable'=>true ,
                    'attr'=>array(
                        'readOnly'=>'true',
                        'placeholder'=> 'Click To Choose',
                        'class' => 'disabled rf-media-form-type',
                        'required' => 'true'
                    ),
                ]
            )

            ->add('image08',
                ElFinderType::class,
                [
                    'instance'=>'gallery',
                    'label' => 'other images',
                    'enable'=>true ,
                    'attr'=>array(
                        'readOnly'=>'true',
                        'placeholder'=> 'Click To Choose',
                        'class' => 'disabled rf-media-form-type',
                        'required' => 'true'
                    ),
                ]
            )

            ->add('image09',
                ElFinderType::class,
                [
                    'instance'=>'gallery',
                    'label' => 'other images',
                    'enable'=>true ,
                    'attr'=>array(
                        'readOnly'=>'true',
                        'placeholder'=> 'Click To Choose',
                        'class' => 'disabled rf-media-form-type',
                        'required' => 'true'
                    ),
                ]
            )

            ->add('attribute01',
                TextType::class,
                [
                    'label' => 'Name',
                    'attr' => [],
                    'help' => 'The name of the attribute.',
                    'required' => false
                ]
            )

            ->add('attribute01Value',
                TextType::class,
                [
                    'label' => 'Value',
                    'attr' => [],
                    'help' => 'The value of the attribute.',
                    'required' => false
                ]
            )

            ->add('attribute02',
                TextType::class,
                [
                    'label' => 'Name',
                    'attr' => [],
                    'help' => 'The name of the attribute.',
                    'required' => false
                ]
            )

            ->add('attribute02Value',
                TextType::class,
                [
                    'label' => 'Value',
                    'attr' => [],
                    'help' => 'The value of the attribute.',
                    'required' => false
                ]
            )

            ->add('attribute03',
                TextType::class,
                [
                    'label' => 'Name',
                    'attr' => [],
                    'help' => 'The name of the attribute.',
                    'required' => false
                ]
            )

            ->add('attribute03Value',
                TextType::class,
                [
                    'label' => 'Value',
                    'attr' => [],
                    'help' => 'The value of the attribute.',
                    'required' => false
                ]
            )

            ->add('attribute04',
                TextType::class,
                [
                    'label' => 'Name',
                    'attr' => [],
                    'help' => 'The name of the attribute.',
                    'required' => false
                ]
            )

            ->add('attribute04Value',
                TextType::class,
                [
                    'label' => 'Value',
                    'attr' => [],
                    'help' => 'The value of the attribute.',
                    'required' => false
                ]
            )

            ->add('attribute05',
                TextType::class,
                [
                    'label' => 'Name',
                    'attr' => [],
                    'help' => 'The name of the attribute.',
                    'required' => false
                ]
            )

            ->add('attribute05Value',
                TextType::class,
                [
                    'label' => 'Value',
                    'attr' => [],
                    'help' => 'The value of the attribute.',
                    'required' => false
                ]
            )

            ->add('question01',
                TextType::class,
                [
                    'label' => 'Question 01',
                    'attr' => [],
                    'required' => false
                ]
            )

            ->add('question02',
                TextType::class,
                [
                    'label' => 'Question 02',
                    'attr' => [],
                    'required' => false
                ]
            )

            ->add('question03',
                TextType::class,
                [
                    'label' => 'Question 03',
                    'attr' => [],
                    'required' => false
                ]
            )

            ->add('question04',
                TextType::class,
                [
                    'label' => 'Question 04',
                    'attr' => [],
                    'required' => false
                ]
            )

            ->add('question05',
                TextType::class,
                [
                    'label' => 'Question 05',
                    'attr' => [],
                    'required' => false
                ]
            )


            ->add('briefDescription',
                TextareaType::class,
                [
                    'label' => 'Brief Description',
                    'help' => 'A brief description of the product'
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
                    'help' => 'Complete details of the product'
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ObjectProduct::class,
        ]);
    }
}