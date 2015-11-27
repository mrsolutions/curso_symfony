<?php

namespace Curso\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Collection;

class FAQContactoType extends AbstractType //automaticamente extiende a esta clase que contiene lo necesario para crear formularios
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) //crea el formulario
    {
    	$builder
    		->add('name', 'text', array(
    				'required'=>true,
    				'invalid_message' => 'Se necesita un nombre.',
    				'attr' => array(
    					'placeholder' => 'Nombre',
    					'pattern'     => '.{2,}' //minlength
    				)
    		))
            ->add('email', 'email', array(
            		'required'=>true,
            		'invalid_message' => 'Se necesita un e-mail.',
	                'attr' => array(
	                	'placeholder' => 'Dirección de correo electrónico'
	                )
            )) 
            ->add('message', 'textarea', array(
            		'required'=>true,
            		'invalid_message' => 'No ha escrito el mensaje.',
	                'attr' => array(
	                    'cols' => 90,
	                    'rows' => 10,
	                    'placeholder' => 'Cuerpo del mensaje'
	                )
            ))
            ->add('Enviar', 'submit');
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    	$collectionConstraint = new Collection(array(
    			'name' => array(
    			),
    			'email' => array(
    			),
    			'message' => array(
    			)
    	));
    
    	$resolver->setDefaults(array(
    			'constraints' => $collectionConstraint
    	));
    }
    
    public function getName()
    {
    	return 'feedback';
    }
}