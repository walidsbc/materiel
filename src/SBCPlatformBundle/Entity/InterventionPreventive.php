<?php

namespace SBCPlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InterventionPreventive
 *
 * @ORM\Table(name="intervention_preventive")
 * @ORM\Entity(repositoryClass="SBCPlatformBundle\Repository\InterventionPreventiveRepository")
 */
class InterventionPreventive extends Intervention
{

    /**
     * @ORM\ManyToOne(targetEntity="SBCPlatformBundle\Entity\PlanificationPrevention", cascade={"persist", "merge", "remove"})
     * @ORM\JoinColumns({ @ORM\JoinColumn(name="planification_id", referencedColumnName="id")})
     */
    private $planificationPreventive;


    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Set planificationPreventive
     *
     * @param \SBCPlatformBundle\Entity\PlanificationPrevention $planificationPreventive
     *
     * @return InterventionPreventive
     */
    public function setPlanificationPreventive(PlanificationPrevention $planificationPreventive)
    {
        $this->planificationPreventive = $planificationPreventive;

        return $this;
    }

    /**
     * Get planificationPreventive
     *
     * @return \SBCPlatformBundle\Entity\PlanificationPrevention
     */
    public function getPlanificationPreventive()
    {
        return $this->planificationPreventive;
    }

}

