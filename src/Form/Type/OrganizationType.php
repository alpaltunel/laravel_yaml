<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;


class OrganizationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Name of the Organization: '])
            ->add('description', TextareaType::class, ['label' => 'Description: '])
            ->add('users', CollectionType::class, [
                'label' => 'Company Users: ',
                    'allow_add' => true,
                    'allow_delete' => true,
                    'entry_type' => UserType::class
                ]
            )
            ->add('save', SubmitType::class, ['label' => 'Submit']);
    }
}