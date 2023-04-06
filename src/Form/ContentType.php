<?php

namespace App\Form;

use App\Entity\Content;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ContentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('code', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            
            ->add('contentParameters', ContentParameterType::class, [
                'data_class' => null,
                'mapped' => false,
                'label' => 'Parameters',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Create',
                'attr' => ['class' => 'btn btn-primary'],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Content::class,
            'allow_extra_fields' => true,
        ]);
    }
}
