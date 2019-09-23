<?php


namespace App\Form\Type;

use App\Entity\Layout;
use App\Enums\Boolean;
use App\Enums\LayoutCode;
use App\Enums\SlotCode;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class LayoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code',
                ChoiceType::class,
                [
                    'choices' => LayoutCode::getList(),
                    'multiple' => false,
                    'expanded' => false,
                    'label' => "Code for this layout"
                ]
            )
            ->add('title',
                TextType::class
            )
            ->add('description',
                TextareaType::class
            )
            ->add('structure',
                TextareaType::class
            )
            ->add('slots',
                ChoiceType::class,
                [
                    'choices' => SlotCode::getList(),
                    'multiple' => true,
                    'expanded' => false,
                    'label' => "Slots found in this layout"
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Layout::class,
        ]);
    }
}