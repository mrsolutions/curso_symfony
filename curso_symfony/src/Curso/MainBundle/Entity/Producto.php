<?php

namespace Curso\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity
 */
class Producto
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
	
    protected $id;
    /**
     *
     * @ORM\Column(type="string", length=100)
     */
    
    protected $nombre;
    /**
     *
     * @ORM\Column(type="integer")
     */
    
    protected $precio;
    
    //GETTERS
    public function getId()
    {
        return $this->id;
    }
    
    public function getNombre()
    {
    	return $this->nombre;
    }
    
    public function getPrecio()
    {
    	return $this->precio;
    }
    
    //SETTERS

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }
    
    public function setPrecio($precio)
    {
    	$this->precio = $precio;
    
    	return $this;
    }

    
}
