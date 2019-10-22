<?php


namespace App\Form\Type\ContentType;

use App\Entity\Block;
use App\Enums\Roles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class BaseContentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',
                TextType::class,
                [
                    'label' => 'Title',
                    'attr' => array(
                        'class' => "",
                    ),
                    'required'=> false,
                    'help' => "If the content have a title section, this text will be used."
                ]
            )
            ->add('displays', ChoiceType::class, [
                    'choices' => array(
                        'mobile' => 'show_in_mobile',
                        'tablet' => 'show_in_tablet',
                        'desktop' => 'show_in_desktop',
                    ),
                    'multiple' => true,
                    'expanded' => true,
                    'label' => "Show this block in:"
                ]
            )
            ->add('roles',
                ChoiceType::class,
                [
                    'choices' => Roles::getFOListForm(),
                    'multiple' => true,
                    'expanded' => false,
                    'label' => "Roles to access this content",
                    'required' => false
                ]
            )
        ;

        $this->addFields($builder, $options);
    }

    protected function addFields(FormBuilderInterface $builder, array $options)
    {
        //add your fields here
    }
}