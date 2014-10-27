<?php

namespace Org\PartitionneurBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Eleve
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Org\PartitionneurBundle\Entity\EleveRepository")
 */
class Eleve
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;
    
    /**
     * @ORM\ManyToOne(targetEntity="Classe", inversedBy="eleves")
     */
    private $classe;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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
     * Set nom
     *
     * @param string $nom
     * @return Eleve
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return Eleve
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set classe
     *
     * @param \Org\PartitionneurBundle\Entity\Classe $classe
     * @return Eleve
     */
    public function setClasse(\Org\PartitionneurBundle\Entity\Classe $classe = null)
    {
        $this->classe = $classe;

        return $this;
    }

    /**
     * Get classe
     *
     * @return \Org\PartitionneurBundle\Entity\Classe 
     */
    public function getClasse()
    {
        return $this->classe;
    }
}
