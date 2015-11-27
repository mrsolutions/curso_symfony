<?php

namespace Curso\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class NavbarController extends Controller
{
    public function principalAction()
    {
        return $this->render('CursoMainBundle:Hrg:principal.html.twig');
    }
    
    public function empresaAction()
    {
    	return $this->render('CursoMainBundle:Hrg:empresa.html.twig');
    }
    
    public function turismoAction($pueblo)
    {
    	return $this->render('CursoMainBundle:Hrg:turismo.html.twig',array('pueblo'=>$pueblo));
    }
    
    public function contactoAction()
    {
    	return $this->render('CursoMainBundle:Hrg:contacto.html.twig');
    }
}