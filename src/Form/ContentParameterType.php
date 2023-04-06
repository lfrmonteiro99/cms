<?php

namespace App\Form;

use App\Entity\Content;
use App\Entity\ContentParameter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ContentParameterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code')
            ->add('type', ChoiceType::class, [
                'choices' => Content::SECTION_TYPES,
                'attr' => ['class' => 'form-control choice-section-type'],  
            ])
            ->add('text', TextType::class, [
                'label' => 'Value to show',
                'attr' => ['class' => 'form-control'],
                'mapped' => false,
                'required' => false,
            ])
            ->add('heading', NumberType::class, [
                'mapped' => false,
                'label' => 'Number of heading',
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContentParameter::class,
            'allow_extra_fields' => true,
        ]);
    }
}
