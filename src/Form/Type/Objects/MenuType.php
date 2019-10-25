<?php


namespace App\Form\Type\Objects;


use App\Entity\ObjectMenu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuType extends AbstractType
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
                    'help' => 'To be used in the back office only'
                ]
            )
            ->add('properties',
                HiddenType::class,
                [
                    'label' => 'Properties',
                    'required'=> false
                ]
            )

            ->add('menuHTML',
                HiddenType::class,
                [
                    'label' => 'menu in html format',
                    'required'=> false
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ObjectMenu::class,
        ]);
    }
}