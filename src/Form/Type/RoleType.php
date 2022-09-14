<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoleType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'multiple' => true,
            'choices' => [
                'ADMIN' => 'ADMIN',
                'CEO' => 'CEO',
                'CTO' => 'CTO',
                'SALES' => 'SALES',
            ],
        ]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }
}