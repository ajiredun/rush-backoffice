<?php

namespace App\Form\Type\ContentType;

use App\Entity\ObjectMenu;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use FM\ElfinderBundle\Form\Type\ElFinderType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MenuCTType extends BaseContentType
{
    protected function addFields(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('menu',
                EntityType::class,
                [
                    'label' => 'Choose a menu to associate with this block',
                    'attr'=>array(
                    ),
                    'required'=>true,

                    'class' => ObjectMenu::class,
                    'choice_label' => 'name',
                ]
            )

            ->remove('padding')
            ->remove('title')
        ;

        /*$builder->add('users', EntityType::class, [
            'class' => User::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
                    ->orderBy('u.username', 'ASC');
            },
            'choice_label' => 'username',
        ]);*/
    }
}