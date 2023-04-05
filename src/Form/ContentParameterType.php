<?php

namespace App\Form;

use App\Entity\Content;
use App\Entity\ContentParameter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
<<<<<<< Updated upstream
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
=======
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream
                'choices' => Content::SECTION_TYPES,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('text', TextType::class, [
                'label' => 'Value to show',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('heading', NumberType::class, [
                'mapped' => false,
                'label' => 'Number of heading',
                'attr' => ['class' => 'form-control'],
            ])
=======
                'choices' => ContentParameter::TYPES
            ])
            ->add('value')
>>>>>>> Stashed changes
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
