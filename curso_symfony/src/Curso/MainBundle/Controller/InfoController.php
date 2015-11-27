<?php

namespace Curso\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class InfoController extends Controller
{
	//Como es una accion, SIEMPRE ha de llevar el sufijo ACTION
	public function nosotrosAction($nombre,$apellidos,$nacimiento)
	{
		//lo siguiente es una forma de hacerlo pero no es lo correcto para lo que nosotros necesitamos
		
		return new Response ("<html><body> Mi página de información propia; mi nombre es ".$nombre." ".$apellidos." .</body></html>");	 
		 
	}
	
	public function pagina_estaticaAction($pagina)
	{
		//el $response te lleva siempre a la misma página, sea la informacion que sea
		/* $response = $this->forward("CursoMainBundle:Info:nosotros", array("nombre" => "Carlos","apellidos"=>"M.S.", 
				"nacimiento"=>"Castellón"));
		return $response;
		*/
		
		//esto se utiliza para los E_MAILS
		//$mailer = $this->get("mailer");
		
		//Si el request fuese "quienes_somos" se redirige a "info\quien" tambien se puede "www.google.es"
		if ($pagina == "quienes_somos") {
			//return $this->redirect("http://www.google.es");
			
			 /* A generateUrl le pasamos el nombre del routing.yml al meter el array con el "slug
			 * lo que hace es que en la direccion del navegador aparezca 
			 * http://curso_synfony.dev/app_dev.php/info?slug=quien y no sólo http://curso_synfony.dev/app_dev.php/info
			 * */
			 return $this->redirect($this->generateUrl("curso_main_info", array ("slug" => "quien")));
		}
		
		//Si el parametro que se pasa es "quien" o "donde" abre la página correspondiente
		//Si no es ninguno de esos te lleva a una página de excepción
		if ($pagina =="quien" ||$pagina == "donde") {
			return $this->render("CursoMainBundle:Default:".$pagina.".html.twig", array());
		} else {
			throw $this->createNotFoundException("Página no encontrada");
		}
		
	}
}