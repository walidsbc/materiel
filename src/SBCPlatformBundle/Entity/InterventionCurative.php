<?php

namespace SBCPlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InterventionCurative
 *
 * @ORM\Table(name="intervention_curative")
 * @ORM\Entity(repositoryClass="SBCPlatformBundle\Repository\InterventionCurativeRepository")
 */
class InterventionCurative extends Intervention
{


    /**
     * @ORM\ManyToOne(targetEntity="SBCPlatformBundle\Entity\Materiel", inversedBy="planifications", cascade={"persist", "merge", "remove"})
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
        parent::__construct();


    }


    /**
     * Set materiel
     *
     * @param \SBCPlatformBundle\Entity\Materiel $materiel
     *
     * @return InterventionCurative
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
     * @return InterventionCurative
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
        return $this->getNatureintervention()->getName() . " " . $this->getMateriel()->getName();
    }


}

