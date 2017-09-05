<?php

namespace SBCPlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * NatureIntervention
 *
 * @ORM\Table(name="nature_intervention")
 * @ORM\Entity(repositoryClass="SBCPlatformBundle\Repository\NatureInterventionRepository")
 */
class NatureIntervention
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * @Assert\Length(min=2)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationdate", type="datetime")
     * @Assert\DateTime()
     */
    private $creationdate;

//    /**
//     * @var ArrayCollection $typeinterventions
//     *
//     * @ORM\OneToMany(targetEntity="SBCPlatformBundle\Entity\TypeIntervention", mappedBy="natureintervention", cascade={"persist", "remove", "merge"})
//     */
//    private $typeinterventions;


    public function __construct()
    {
        $this->creationdate = new \Datetime();
//        $this->typeinterventions = new ArrayCollection();

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
     * Set name
     *
     * @param string $name
     *
     * @return NatureIntervention
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
     * Set creationdate
     *
     * @param \DateTime $creationdate
     *
     * @return NatureIntervention
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



//    public function addTypeIntervention(TypeIntervention $typeIntervention)
//    {
//        $typeIntervention->setMateriel($this);
//        $this->typeinterventions[] = $typeIntervention;
//
//
//        return $this;
//    }
//
//    public function removeTypeIntervention(TypeIntervention $typeIntervention)
//    {
//        $this->typeinterventions->removeElement($typeIntervention);
//    }
//
//    /**
//     * @return ArrayCollection $typeinterventions
//     */
//    public function getTypeinterventions() {
//        return $this->typeinterventions;
//    }

    public function __toString()
    {
        return $this->name;
    }
}
