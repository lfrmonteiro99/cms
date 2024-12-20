<?php

namespace App\Form;

use App\Entity\Content;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ContentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('code', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('template', ChoiceType::class, [
                'choices' => Content::TEMPLATES,
                'mapped' => false,
                'required' => false,
                'placeholder' => 'Select a template',
                'attr' => ['class' => 'form-control']
            ])
            ->add('menu', CheckboxType::class, [
                'mapped' => false,
                'required' => false,
                'attr' => ['class' => 'form-check-input']
            ])
            ->add('xyz', CKEditorType::class, [
                'mapped' => false,
                'attr' => ['class' => 'hidden'],
                'required' => false
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
