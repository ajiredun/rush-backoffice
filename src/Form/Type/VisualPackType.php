<?php


namespace App\Form\Type;

use App\Entity\VisualPack;
use App\Enums\Boolean;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class VisualPackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code',
                TextType::class,
                [
                    'label' => 'Code (must be something unique)'
                ]
            )
            ->add('title',
                TextType::class
            )
            ->add('active',
                ChoiceType::class,
                [
                    'choices' => Boolean::getChoices(),
                    'multiple' => false,
                    'expanded' => false,
                    'label' => "Activate this visual pack?"
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => VisualPack::class,
        ]);
    }
}