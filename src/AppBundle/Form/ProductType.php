<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('code', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'required' => 'required',
                    'placeholder' => 'Código único de Producto'
                ],
                'label' => 'Código'
            ])
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'required' => 'required',
                    'placeholder' => 'Nombre único de Producto'
                ],
                'label' => 'Nombre'
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'required' => 'required',
                    'rows' => '2'
                ],
                'label' => 'Descripción'
            ])
            ->add('brand', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'required' => 'required',
                    'placeholder' => 'Marca o fabricante del producto'
                ],
                'label' => 'Marca'
            ])
            ->add('price', NumberType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'required' => 'required',
                    'placeholder' => 'Precio del producto, en números, sin comas ni puntos'
                ],
                'label' => 'Precio'
            ])
            ->add('category', EntityType::class, [
                'class' => 'AppBundle:Category',
                'label' => 'Categoría',
                'attr' => [
                    'class' => 'form-control',
                    'required' => 'required'
                ]
            ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Product'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_product';
    }


}
