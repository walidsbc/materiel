<?php

namespace SBCPlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Intervention
 *
 * @ORM\Table(name="intervention")
 * @ORM\Entity(repositoryClass="SBCPlatformBundle\Repository\InterventionRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="typeintervention", type="string")
 * @ORM\DiscriminatorMap({"intervention" = "Intervention", "intervention_curative" = "InterventionCurative", "intervention_preventive" = "InterventionPreventive"})
 */
class Intervention
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
     * @var \DateTime
     *
     * @ORM\Column(name="creationdate", type="datetime")
     * @Assert\DateTime()
     */
    private $creationdate;


    /**
     * @ORM\ManyToOne(targetEntity="SBCPlatformBundle\Entity\Ouvrier")
     * @ORM\JoinColumn(nullable=false)
     */
    private $interferedby;


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
     * Set interferedby
     *
     * @param \SBCPlatformBundle\Entity\Ouvrier $pointedby
     *
     * @return Intervention
     */
    public function setInterferedby(\SBCPlatformBundle\Entity\Ouvrier $interferedby)
    {
        $this->interferedby = $interferedby;

        return $this;
    }

    /**
     * Get interferedby
     *
     * @return \SBCPlatformBundle\Entity\Ouvrier
     */
    public function getInterferedby()
    {
        return $this->interferedby;
    }

    /**
     * Set creationdate
     *
     * @param \DateTime $creationdate
     *
     * @return Intervention
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
        return $this->creationdate->format('d.m.Y');
    }
}
