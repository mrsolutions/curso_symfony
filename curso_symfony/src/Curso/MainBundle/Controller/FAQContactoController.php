<?php

namespace Curso\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Curso\MainBundle\Form\FAQContactoType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Symfony\Component\Config;
use Symfony\Component\Filesystem\Filesystem;
//use IIB;
use Symfony\Component\Translation\Tests\String;

class FAQContactoController extends Controller
{
	/*
	 * al usuario
	 */
	public function sendUserConfirmAction (array $inputs) {
		
		$email = $inputs['email'];
	
		$mailer = $this->get('mailer');
		$message = \Swift_Message::newInstance()
		->setSubject('Copia del mensaje enviado a MRGeomatics')
		->setFrom('info@mrgeomatics.es')
		->setTo('email')
		->setBody(
				$this->renderView('CursoMainBundle:FAQ:touser.html.twig', $inputs),
				'text/html'
				);
		$mailer->send($message);
		//$sent = true;
		//return $sent;
	}
	
	/*
	 * a nosotros
	 */
	public function sendUsConfirmAction (array $inputs) {
	
		$email = $inputs['email'];
		$nombre = $inputs['name'];
	
		$mailer = $this->get('mailer');
		$message = \Swift_Message::newInstance()
		->setSubject('Pregunta de FAQ:')
		->setFrom($email)
		->setTo('carlosgeldo@gmail.com')
		->setBody(
				$this->renderView('CursoMainBundle:FAQ:tous.html.twig', $inputs),
				'text/html'
				);
		$mailer->send($message);
	}
	
	/*
	 * ejecución botón
	 */
	public function enviarAction(Request $request){
		$form=$this->createForm(new FAQContactoType());
		$form->handleRequest($request);
		
		if($form->isValid()) {
			$this->sendUserConfirmAction($form);
			$this->sendUsConfirmAction($form);
			
			return $this->render('CursoMainBundle:FAQ:submited.html.twig');
		}
		return $this->render('CursoMainBundle:Hrg:contacto.html.twig',array('form'=>$form->createView()));
	}
}
