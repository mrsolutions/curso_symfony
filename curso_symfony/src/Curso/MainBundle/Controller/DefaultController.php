<?php

namespace Curso\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CursoMainBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function ayudaAction($tema)
    {
    	//lo siguiente es una forma de hacerlo pero no es lo correcto para lo que nosotros necesitamos
    	//return new Response("<html><body> Esta es la ayuda sobre el tema ".$tema."</body></html>");
    	
    	//LO CORRECTO: crear una plantilla en Resources/views/Default
    	//Para ello se copia el archivo index.default.twig se pega y eclipse te dice que si quieres renombrarlo
    	// En nuestro caso se ha llamado ayuda.html.twig y vamos a ver que hacer con él:
    	
    	return $this->render("CursoMainBundle:Default:ayuda.html.twig", array ("tema" => $tema));
    	
    	
    }
}
