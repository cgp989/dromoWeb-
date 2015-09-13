<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rol
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\RolRepository")
 */
class Rol
{

    /**
     * @var integer
     *
     * @ORM\Column(name="idRol", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idRol;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=100)
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity="Usuario", mappedBy="rol")
     */
    protected $usuarios;

    public function __construct()
    {
        $this->usuarios = new ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idRol
     *
     * @param integer $idRol
     * @return Rol
     */
    public function setIdRol($idRol)
    {
        $this->idRol = $idRol;

        return $this;
    }

    /**
     * Get idRol
     *
     * @return integer 
     */
    public function getIdRol()
    {
        return $this->idRol;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Rol
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Add usuarios
     *
     * @param \AppBundle\Entity\Usuario $usuarios
     * @return Rol
     */
    public function addUsuario(\AppBundle\Entity\Usuario $usuarios)
    {
        $this->usuarios[] = $usuarios;

        return $this;
    }

    /**
     * Remove usuarios
     *
     * @param \AppBundle\Entity\Usuario $usuarios
     */
    public function removeUsuario(\AppBundle\Entity\Usuario $usuarios)
    {
        $this->usuarios->removeElement($usuarios);
    }

    /**
     * Get usuarios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }
}
