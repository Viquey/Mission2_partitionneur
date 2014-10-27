<?php

namespace Org\PartitionneurBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Classe
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Org\PartitionneurBundle\Entity\ClasseRepository")
 */
class Classe
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     * @ORM\OneToMany(targetEntity="Eleve", mappedBy="classe")
     *
     */
    private $eleves;
    
    /**
     * @ORM\ManyToMany(targetEntity="\Org\UserBundle\Entity\User", mappedBy="classes")
     * 
     */
    private $users;


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
     * Set name
     *
     * @param string $name
     * @return Classe
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->eleves = new \Doctrine\Common\Collections\ArrayCollection();
        $this->groups = new ArrayCollection();
    }

    /**
     * Add eleves
     *
     * @param \Org\PartitionneurBundle\Entity\Eleve $eleves
     * @return Classe
     */
    public function addElefe(\Org\PartitionneurBundle\Entity\Eleve $eleves)
    {
        $this->eleves[] = $eleves;

        return $this;
    }

    /**
     * Remove eleves
     *
     * @param \Org\PartitionneurBundle\Entity\Eleve $eleves
     */
    public function removeElefe(\Org\PartitionneurBundle\Entity\Eleve $eleves)
    {
        $this->eleves->removeElement($eleves);
    }

    /**
     * Get eleves
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEleves()
    {
        return $this->eleves;
    }
    
    /**
     * Set classes
     *
     * @param \Org\UserBundle\Entity\User $user
     * @return Classe
     */
    public function setUsers($user)
    {
        $this->users[] = $user;

        return $this;
    }
    
    /**
     * @inheritDoc
     */
    public function getUsers()
    {
        return $this->users->toArray();
    }
}
