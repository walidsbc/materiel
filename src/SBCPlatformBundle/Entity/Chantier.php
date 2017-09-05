<?php

namespace SBCPlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Chantier
 *
 * @ORM\Table(name="chantier")
 * @ORM\Entity(repositoryClass="SBCPlatformBundle\Repository\ChantierRepository")
 */
class Chantier extends Emplacement
{


    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=false)
     * @Assert\Length(min=2)
     */
    private $status;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="begindate", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $begindate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="finishdate", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $finishdate;

    public function __construct()
    {
        parent::__construct();

        $this->status = "Préparation";
    }




    /**
     * Set begindate
     *
     * @param \DateTime $begindate
     *
     * @return Chantier
     */
    public function setBegindate($begindate)
    {
        $this->begindate = $begindate;

        return $this;
    }

    /**
     * Get begindate
     *
     * @return \DateTime
     */
    public function getBegindate()
    {
        
            return $this->begindate;
       
    }

    /**
     * Set finishdate
     *
     * @param \DateTime $finishdate
     *
     * @return Chantier
     */
    public function setFinishdate($finishdate)
    {
        $this->finishdate = $finishdate;

        return $this;
    }

    /**
     * Get finishdate
     *
     * @return \DateTime
     */
    public function getFinishdate()
    {
       
            return $this->finishdate;
       
    }



    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Chantier
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    public function validateDates()
    {
        if ($this->status == 'Cloturé' and $this->finishdate < $this->begindate) {

            return false;
        }
        return true;

    }

//    /**
//     * @Assert\Callback
//     */
//    public function validateDates(ExecutionContextInterface $context)
//    {
//        if ($this->status == 'Cloturé' and $this->finishdate < $this->begindate)
//
//            $context->buildViolation('Date de fin doit être supérieure ou égale à la date de début ')
//                ->atPath('finishdate')
//                ->addViolation();
//
//    }

}
