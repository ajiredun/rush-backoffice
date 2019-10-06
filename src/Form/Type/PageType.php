<?php

namespace App\Form\Type;


use App\Entity\Page;
use App\Enums\Boolean;
use App\Enums\LayoutCode;
use App\Enums\Roles;
use App\Enums\SlotCode;
use App\Form\DataTransformer\LayoutToNumberTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
    private $transformer;

    public function __construct(LayoutToNumberTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('route',
                TextType::class,
                [
                    'label' => 'URL (example: our-services)',
                    'attr' => array(
                        'class' => "my_page_route",
                    ),
                    'disabled'=> $options['edit_mode']
                ]
            )
            ->add('name',
                TextType::class,
                [
                    'label' => 'Name (example: Our Services)',
                    'attr' => array(
                        'class' => "my_page_name",
                    ),
                ]
            )
            ->add('layout', HiddenType::class, [
                    'attr' => array(
                        'class' => "my_page_layout",
                    ),
                    'label' => "Choose your page layout",
                    'invalid_message' => 'That is not a valid layout id',
                ]
            )
            ->add('roles',
                ChoiceType::class,
                [
                    'choices' => Roles::getFOListForm(),
                    'multiple' => true,
                    'expanded' => false,
                    'label' => "Roles to access this page.",
                    'required' => false
                ]
            )

            ->add('seoAllowRobot', ChoiceType::class, [
                    'choices' => array(
                        'Yes' => true,
                        'No' => false
                    ),
                    'multiple' => false,
                    'expanded' => false,
                    'label' => "See this page in search results?"
                ]
            )

            ->add('seoTitle',
                TextType::class,
                [
                    'label' => 'Page Title',
                    'required'=>false,
                ]
            )
            ->add('seoAuthor',
                TextType::class,
                [
                    'label' => 'Author',
                    'required'=>false,
                ]
            )
            ->add('seoMetaDescription',
                TextareaType::class,
                [
                    'label' => 'Page Description',
                    'required'=>false,
                ]
            )
            ->add('seoKeywords',
                TextType::class,
                [
                    'label' => 'Page Keywords. Example: (Dog, Berger, German Shephard, Breed)',
                    'required'=>false,
                ]
            )

        ;

        $builder->get('layout')
            ->addModelTransformer($this->transformer);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Page::class,
            'edit_mode' => false,
            'clone_mode' => false,
        ]);

        $resolver->setAllowedTypes('edit_mode', 'bool');
        $resolver->setAllowedTypes('clone_mode', 'bool');
    }
}