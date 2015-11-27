<?php

namespace Curso\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Curso\MainBundle\Entity\Producto;
use Curso\MainBundle\Entity\Ciudad;
use Curso\MainBundle\Form\ProductoType;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{

	//Toma un producto y su precio para anyadirlo a la base de datos
	public function addOneAction($nombre,$precio) 	{
		//creo un nuevo Producto y le ajusto los valores
		$producto = new Producto(); 
		$producto ->setNombre($nombre); 
		$producto ->setPrecio($precio);
		
		//Lo de antes esta dentro de symfony (PHP), para pasarlo a la base de datos:
		$em = $this->getDoctrine()->getManager(); //el Manager me comunica con la base de datos
		$em->persist($producto);//persist le pasa lo que quiero que aparezca en el Manager.
		//lo que consigue es que esta entidad de PHP se convierta en un objeto de Doctrine.
		$em -> flush(); //con esto lo guarda en la base de datos, si no se hace "flush" no se ha guardado nada en la BD
		
		return new Response (
				'Id del nuevo producto: '.$producto->getId().'; el producto se ha creado bien');
	}
	
	//Devuelve una lista con todos los productos de la base de datos
	/*public function getAllAction() {
		$em =$this->getDoctrine()->getManager(); //el Manager me comunica con la BD
		$productos =$em->getRepository('CursoMainBundle:Producto')->findAll();//el getRepository necesita la entidad con la 
		//que voy a trabajar, sabido eso llamo a la función findAll que me devuelve todos los productos
		$res = "Productos:<br>";
		foreach ($productos as $producto) { //hace que saque uno por uno todos los productos, como una lista
			$res .= $producto->getNombre(). ' Precio: '.$producto->getPrecio(). '<br>';
		}
		return new Response($res);
	}*/
	
	//Devuelve una lista con todos los productos de la base de datos, 
	//*****USAREMOS TWIGS*****
	public function getAllAction() {
	 $em =$this->getDoctrine()->getManager(); //el Manager me comunica con la BD
	 $productos =$em->getRepository('CursoMainBundle:Producto')->findAll();//el getRepository necesita la entidad con la
	 //que voy a trabajar, sabido eso llamo a la función findAll que me devuelve todos los productos
	 
	 $em =$this->getDoctrine()->getManager(); //el Manager me comunica con la BD
	 $ciudades =$em->getRepository('CursoMainBundle:Ciudad')->findAll();//el getRepository necesita la entidad con la
	 //que voy a trabajar, sabido eso llamo a la función findAll que me devuelve todos las ciudades
	 
	 //con render le digo que utilice la plantilla productos.html.twig y que le pase el arrary asociativo
	 //la plantilla contendrá los datos que le pase y podrá utilizarlos para lo que quiera
	 return $this->render("CursoMainBundle:Default:productos.html.twig", array("productos"=>$productos, "ciudades"=>$ciudades));
	 }
	
	
	//Devuelve la información de un producto buscandola por el identificador
	public function getByIdAction($id) {
		$em =$this->getDoctrine()->getManager();//el Manager me comunica con la BD
		//$producto = $em->find('CursoMainBundle:Producto', $id); ------> sería un atajo, busca el valor de $id
		//$producto = $em->getRepository('CursoMainBundle:Producto')->find($id); ------> sería otro atajo
		//este último atajo es como el de getAll, le digo que vaya al repositorio y que busque el valor de $id
		$producto =$em->getRepository('CursoMainBundle:Producto')->findOneById($id); //Este busca el valor de $id sólo 
		//en el campo en que se le indica, así es, sólo en la columna del identificador
		return new Response(
				'Producto: '.$producto->getNombre().' con precio '.$producto->getPrecio()
				);	
	}
	
	//Devuelve la información de un producto buscandola por el nombre
	public function getByNombreAction($nombre) {
		$em =$this->getDoctrine()->getManager();//el Manager me comunica con la BD
		//$producto = $repository->findByNombre($nombre);
		$producto =$em->getRepository('CursoMainBundle:Producto')->findOneByNombre($nombre);
		//es como el de buscar por $id pero buscamos sólo en la columna nombre al usar findOneByNombre
		
		//$producto = $em->getRepository('CursoMainBundle:Producto')->findBy(array("nombre" =>$nombre), 20, 0);
		//Este método de arriba es más potente, dentro del findBy le paso un array con los criterios de búsqueda
		//Por ejemplo, busca en la columna "nombre" el valor $nombre, que me recupere 20 registros a partir de
		//que registro quiero que me devuelva registros. Esto es muy comodo para cuando los datos tengan una salida 
		//de paginación
		
		return new Response(
				'Producto: '.$producto->getNombre().' con precio '.$producto->getPrecio()
		);
		//en caso de utilizar find() o findBy() voy a tener un array, una lista y necesitaré un "foreach" como en el caso 
		//de getAllAction para mostrarlos por pantalla.
	}
	
	//Actualiza la información de un producto
	public function updateAction($id, $nombre, $precio) {
		$em =$this->getDoctrine()->getManager();//el Manager me comunica con la BD
		$producto = $em->getRepository('CursoMainBundle:Producto')->find($id); //va al repositorio y busca el valor de $id
		if (!$producto) {
			throw $this->createNotFoundException(
					'No se ha encontrado el producto para el identificador '.$id
					);
		}
		
		$producto->setNombre($nombre);
		$producto->setPrecio($precio);
		
		$em->flush();
		
		return new Response(
				'Producto: '.$producto->getNombre().' con precio '.$producto->getPrecio()
		);
	}
	
	//Borra un producto de la BD
	public function deleteAction($id) {
		$em =$this->getDoctrine()->getManager();//el Manager me comunica con la BD
		$producto = $em->getRepository('CursoMainBundle:Producto')->find($id); //va al repositorio y busca el valor de $id
		if (!$producto) {
			throw $this->createNotFoundException(
					'No se ha encontrado el producto para el identificador '.$id
			);
		}
		
		$em->remove($producto);
		$em->flush();
		return new Response('El producto con el identificador '.$id.' ha sido eliminado.');
	}
	
	//Crea un formulario para un nuevo producto
	public function nuevoProductoAction(Request $request){ //el Request sirve para validar el formulario antes de mandarlo
		$producto = new Producto(); //creamos un objeto de entidad Producto	
		//$form= $this->createForm(new ProductoType());//crea un nuevo formulario según la construcción de ProductoType.php
		
		//Necesito asociar el $request al $producto
		$form=$this->createForm(new ProductoType(), $producto);//creo el formulario y le paso $producto(aunque ahora esta vacio)
		$form->handleRequest($request); //el metodo handleRequest toma un $request y se lo asocia al objeto que se pasa
		//como segundo parametro, es decir, $producto
		
		if($form->isValid()) { //isValid devuelve si es valido o no
			$em = $this->getDoctrine()->getManager();//recupero el manager
			$em ->persist($producto);//persisto en los datos
			$em->flush();//gravo en la BD
			
			
			return $this->redirect($this->generateUrl('curso_main_allProd'));
		}
		
	
	return $this->render("CursoMainBundle:Default:formulario.html.twig", array("form"=>$form->createView()));
	}
	
	//Edita un producto de la BD
	public function editProductoAction(Request $request, $id){
		// create a task and give it some dummy data for this example
		$em = $this->getDoctrine()->getManager();
		$producto = $em->getRepository('CursoMainBundle:Producto')->findOneById($id);//busco el producto por el campo id 
		//y lo almaceno en una variable
	
		$form = $this->createForm(new ProductoType(), $producto); //$producto se lo paso al formulario y ya es capaz 
		//de rellenarse ese formulario con los datos correctos
	
		$form->handleRequest($request);
	
		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($producto);
			$em->flush();
	
			return $this->redirect($this->generateUrl('curso_main_allProd'));
		}
	
		return $this->render("CursoMainBundle:Default:formulario.html.twig", array(
				"form"=>$form->createView()
		));
	}	
}