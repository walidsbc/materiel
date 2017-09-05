<?php

namespace SBCPlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PlanificationPrevention
 *
 * @ORM\Table(name="planification_prevention")
 * @ORM\Entity(repositoryClass="SBCPlatformBundle\Repository\PlanificationPreventionRepository")
 */
class PlanificationPrevention
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
     * @var int
     *
     * @ORM\Column(name="threshold", type="integer")
     */
    private $threshold;

    /**
     * @var int
     *
     * @ORM\Column(name="cyclevalue", type="integer")
     */
    private $cyclevalue;

    /**
     * @var int
     *
     * @ORM\Column(name="sumuseddurationsofpointages", type="integer")
     */
    private $sumuseddurationsofpointages;



    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationdate", type="datetime")
     * @Assert\DateTime()
     */
    private $creationdate;


    /**
     * @ORM\ManyToOne(targetEntity="SBCPlatformBundle\Entity\Materiel", inversedBy="planifications")
     * @ORM\JoinColumns({ @ORM\JoinColumn(name="materiel_id", referencedColumnName="id")})
     */

    private $materiel;

    /**
     * @ORM\ManyToOne(targetEntity="SBCPlatformBundle\Entity\NatureIntervention", cascade={"persist", "merge", "remove"})
     * @ORM\JoinColumns({ @ORM\JoinColumn(name="natureintervention_id", referencedColumnName="id")})
     */

    private $natureintervention;


    public function __construct()
    {

        $this->sumuseddurationsofpointages = 0;
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
     * Set threshold
     *
     * @param integer $threshold
     *
     * @return PlanificationPrevention
     */
    public function setThreshold($threshold)
    {
        $this->threshold = $threshold;

        return $this;
    }

    /**
     * Get threshold
     *
     * @return int
     */
    public function getThreshold()
    {
        return $this->threshold;
    }

    /**
     * Set cyclevalue
     *
     * @param integer $cyclevalue
     *
     * @return PlanificationPrevention
     */
    public function setCyclevalue($cyclevalue)
    {
        $this->cyclevalue = $cyclevalue;

        return $this;
    }

    /**
     * Get cyclevalue
     *
     * @return int
     */
    public function getCyclevalue()
    {
        return $this->cyclevalue;
    }

    /**
     * Set sumuseddurationsofpointages
     *
     * @param integer $sumuseddurationsofpointages
     *
     * @return PlanificationPrevention
     */
    public function setSumuseddurationsofpointages($sumuseddurationsofpointages)
    {
        $this->sumuseddurationsofpointages = $sumuseddurationsofpointages;

        return $this;
    }

    /**
     * Get sumuseddurationsofpointages
     *
     * @return int
     */
    public function getSumuseddurationsofpointages()
    {
        return $this->sumuseddurationsofpointages;
    }





    /**
     * Set creationdate
     *
     * @param \DateTime $creationdate
     *
     * @return PlanificationPrevention
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

    /**
     * Set materiel
     *
     * @param \SBCPlatformBundle\Entity\Materiel $materiel
     *
     * @return PlanificationPrevention
     */
    public function setMateriel(\SBCPlatformBundle\Entity\Materiel $materiel = null)
    {
        $this->materiel = $materiel;

        return $this;
    }

    /**
     * Get materiel
     *
     * @return \SBCPlatformBundle\Entity\Materiel
     */
    public function getMateriel()
    {
        return $this->materiel;
    }



    /**
     * Set natureintervention
     *
     * @param \SBCPlatformBundle\Entity\NatureIntervention $natureintervention
     *
     * @return PlanificationPrevention
     *
     */
    public function setNatureintervention(\SBCPlatformBundle\Entity\NatureIntervention $natureintervention = null)
    {
        $this->natureintervention = $natureintervention;

        return $this;
    }

    /**
     * Get natureintervention
     *
     * @return \SBCPlatformBundle\Entity\NatureIntervention
     */
    public function getNatureintervention()
    {
        return $this->natureintervention;
    }


    public function __toString()
    {
        return  $this->getNatureintervention()->getName()." ".$this->getMateriel()->getName();
    }

}

