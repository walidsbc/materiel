<?php

namespace SBCPlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Emplacement
 *
 * @ORM\Table(name="emplacement")
 * @ORM\Entity(repositoryClass="SBCPlatformBundle\Repository\EmplacementRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="typeemplacement", type="string")
 * @ORM\DiscriminatorMap({"emplacement" = "Emplacement", "chantier" = "Chantier", "depot" = "Depot"})
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields="code", message="Ce code existe déjà.")
 */
class Emplacement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * @Assert\Length(min=2)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255, unique=true, nullable=false)
     * @Assert\Length(min=2)
     */
    private $code;



    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=255, nullable=false)
     * @Assert\Length(min=2)
     */
    private $location;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationdate", type="datetime", nullable=false)
     * @Assert\DateTime()
     */
    private $creationdate;


    public function __construct()
    {
        $this->creationdate = new \Datetime();

    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get typeemplacement
     *
     * @return string
     */
    public function getTypeEmplacement()
    {
        $type = explode('\\', get_class($this));

        return end($type);
    }


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Emplacement
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
     * Set code
     *
     * @param string $code
     *
     * @return Emplacement
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }


    /**
     * Set location
     *
     * @param string $location
     *
     * @return Emplacement
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set creationdate
     *
     * @param \DateTime $creationdate
     *
     * @return Emplacement
     */
    public function setCreationdate($creationdate)
    {
        $this->creationdate = $creationdate;

        return $this;
    }

    /**
     * Get creationdate
     *
     * @return \DateTime
     */
    public function getCreationdate()
    {
        return $this->creationdate;
    }

    public function __toString()
    {
        return $this->name;
    }
}

