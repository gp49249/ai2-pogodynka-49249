<?php

namespace App\Form;

use App\Entity\Forecast;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ForecastType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Date', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
            ])
            ->add('Temperature', NumberType::class, [
                'attr' => [
                    'min' => -20,
                    'max' => 40,
                ],
                'html5' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('Rainfall', NumberType::class, [
                'html5' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\GreaterThanOrEqual(0),
                ],
            ])
            ->add('Humidity', NumberType::class, [
                'html5' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\GreaterThanOrEqual(0),
                ],
            ])
            ->add('Wind', TextType::class, [
                'constraints' => [
                    new Assert\Choice([
                        'choices' => ['Calm', 'Moderate', 'Strong'],
                        'message' => 'Invalid wind value. Choose from Calm, Moderate, or Strong.',
                    ]),
                ],
            ])
            ->add('city', EntityType::class, [
                'class' => 'App\Entity\City',
                'choice_label' => 'CityName', // Dostosuj to pole do rzeczywistej nazwy w Twojej encji City
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Forecast::class,
        ]);
    }
}
