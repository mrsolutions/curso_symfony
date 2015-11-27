<?php

namespace Curso\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductoType extends AbstractType //automaticamente extiende a esta clase que contiene lo necesario para crear formularios
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) //crea el formulario
    {
        $builder // me permite anyadir los campos que quiero utilizar
            ->add('nombre','text', array('required'=>true, 'invalid_message'=> 'Se necesita un nombre')) //defino el tipo de dato y que este campo sea obligatorio
            ->add('precio','integer', array('required'=>true, 'invalid_message'=> 'Seguro que es gratis?'))
            ->add('Guardar','submit') //será botón guardar de tipo submit
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array( //opciones por defecto, se define la clase de datos relacionada
            'data_class' => 'Curso\MainBundle\Entity\Producto'
        ));
    }

    /**
     * @return string
     */
    public function getName() //sirve para recuperar el nombre del formulario si he de tener acceso a él
    {
        return 'curso_mainbundle_producto';
    }
}

