<?php

namespace SBCPlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/** @ORM\Entity(repositoryClass="SBCPlatformBundle\Repository\DeplacementRepository")
 * @ORM\Table(name="deplacement")
 */
class Deplacement
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
     * @ORM\Column(name="reference", type="string", length=255)
     * @Assert\Length(min=2)
     */
    private $reference;

    /**
     * @ORM\ManyToOne(targetEntity="SBCPlatformBundle\Entity\Materiel", inversedBy="deplacements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $materiel;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationdate", type="datetime")
     * @Assert\DateTime()
     */
    private $creationdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="departuredate", type="datetime")
     */
    private $departuredate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="arriveddate", type="datetime", nullable=true)
     */
    private $arriveddate;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="SBCPlatformBundle\Entity\Ouvrier")
     * @ORM\JoinColumn(nullable=false)
     */
    private $transmitter;

    /**
     * @ORM\ManyToOne(targetEntity="SBCPlatformBundle\Entity\Ouvrier")
     * @ORM\JoinColumn(nullable=false)
     */
    private $deliverer;

    /**
     * @ORM\ManyToOne(targetEntity="SBCPlatformBundle\Entity\Ouvrier")
     * @ORM\JoinColumn(nullable=true)
     */
    private $deliveredby;

    /**
     * @ORM\ManyToOne(targetEntity="SBCPlatformBundle\Entity\Ouvrier")
     * @ORM\JoinColumn(nullable=true)
     */
    private $receiver;

    /**
     * @var boolean
     *
     * @ORM\Column(name="cancelled", type="boolean", nullable=false)
     */
    private $cancelled;

    /**
     * @var string
     *
     * @ORM\Column(name="reason", type="string", length=255, nullable=true)
     * @Assert\Length(min=10)
     */
    private $reason;

    /**
     * @var boolean
     *
     * @ORM\Column(name="cancellable", type="boolean", nullable=false)
     */
    private $cancellable;


    /**
     * @var string
     *
     *
     * @ORM\ManyToOne(targetEntity="SBCPlatformBundle\Entity\Emplacement")
     * @ORM\JoinColumn(nullable=false)
     */
    private $currentlocation;

    /**
     * @var string
     *
     *
     * @ORM\ManyToOne(targetEntity="SBCPlatformBundle\Entity\Emplacement")
     * @ORM\JoinColumn(nullable=false)
     */
    private $destinatedlocation;


    /**
     * Set currentlocation
     *
     * @param string $currentlocation
     *
     * @return Deplacement
     */
    public function setCurrentlocation($currentlocation)
    {
        $this->currentlocation = $currentlocation;

        return $this;
    }

    /**
     * Get currentlocation
     *
     * @return string
     */
    public function getCurrentlocation()
    {
        return $this->currentlocation;
    }

    /**
     * Set destinatedlocation
     *
     * @param string $destinatedlocation
     *
     * @return Deplacement
     */
    public function setDestinatedlocation($destinatedlocation)
    {
        $this->destinatedlocation = $destinatedlocation;

        return $this;
    }

    /**
     * Get destinatedlocation
     *
     * @return string
     */
    public function getDestinatedlocation()
    {
        return $this->destinatedlocation;
    }


    /**
     * @Assert\Callback
     */
    public function validateCurrentDestinatedLocation(ExecutionContextInterface $context)
    {
        if ($this->currentlocation == $this->destinatedlocation)

            $context->buildViolation('Vous ne pouvez pas transférer un matériel vers le même emplacement du départ ')
                ->atPath('destinatedlocation')
                ->addViolation();

    }


    public function __construct()
    {
        $this->creationdate = new \Datetime();
        $this->cancelled = false;
        $this->cancellable = true;
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
     * Set creationdate
     *
     * @param \DateTime $creationdate
     *
     * @return Deplacement
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
     * Set departuredate
     *
     * @param \DateTime $departuredate
     *
     * @return Deplacement
     */
    public function setDeparturedate($departuredate)
    {
        $this->departuredate = $departuredate;

        return $this;
    }

    /**
     * Get departuredate
     *
     * @return \DateTime
     */
    public function getDeparturedate()
    {


//        if ($this->departuredate === null)
//            return $this->departuredate;
//        return $this->departuredate->format('d.m.Y');
        return $this->departuredate;


    }

    /**
     * Set arriveddate
     *
     * @param \DateTime $arriveddate
     *
     * @return Deplacement
     */
    public function setArriveddate($arriveddate)
    {
        $this->arriveddate = $arriveddate;

        return $this;
    }

    /**
     * Get arriveddate
     *
     * @return \DateTime
     */
    public function getArriveddate()
    {

//        if ($this->arriveddate === null)
//            return $this->arriveddate;
//        return $this->arriveddate->format('d.m.Y');
        return $this->arriveddate;

    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Deplacement
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get typedeplacement
     *
     * @return string
     */
    public function getTypedeplacement()
    {
        $type = explode('\\', get_class($this));

        return end($type);
    }

    /**
     * Set materiel
     *
     * @param \SBCPlatformBundle\Entity\Materiel $materiel
     *
     * @return Deplacement
     */
    public function setMateriel(\SBCPlatformBundle\Entity\Materiel $materiel)
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
     * Set transmitter
     *
     * @param \SBCPlatformBundle\Entity\Ouvrier $transmitter
     *
     * @return Deplacement
     */
    public function setTransmitter(\SBCPlatformBundle\Entity\Ouvrier $transmitter)
    {
        $this->transmitter = $transmitter;

        return $this;
    }

    /**
     * Get transmitter
     *
     * @return \SBCPlatformBundle\Entity\Ouvrier
     */
    public function getTransmitter()
    {
        return $this->transmitter;
    }

    /**
     * Set deliverer
     *
     * @param \SBCPlatformBundle\Entity\Ouvrier $deliverer
     *
     * @return Deplacement
     */
    public function setDeliverer(\SBCPlatformBundle\Entity\Ouvrier $deliverer)
    {
        $this->deliverer = $deliverer;

        return $this;
    }

    /**
     * Get deliverer
     *
     * @return \SBCPlatformBundle\Entity\Ouvrier
     */
    public function getDeliverer()
    {
        return $this->deliverer;
    }

    /**
     * Set receiver
     *
     * @param \SBCPlatformBundle\Entity\Ouvrier $receiver
     *
     * @return Deplacement
     */
    public function setReceiver(\SBCPlatformBundle\Entity\Ouvrier $receiver)
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * Get receiver
     *
     * @return \SBCPlatformBundle\Entity\Ouvrier
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * Set deliveredby
     *
     * @param \SBCPlatformBundle\Entity\Ouvrier $deliveredby
     *
     * @return Deplacement
     */
    public function setDeliveredby(\SBCPlatformBundle\Entity\Ouvrier $deliveredby)
    {
        $this->deliveredby = $deliveredby;

        return $this;
    }

    /**
     * Get deliveredby
     *
     * @return \SBCPlatformBundle\Entity\Ouvrier
     */
    public function getDeliveredby()
    {
        return $this->deliveredby;
    }


//    /**
//     * @Assert\Callback
//     */
//    public function validateDates(ExecutionContextInterface $context)
//    {
//        if ($this->status == 'Arrivé' and $this->arriveddate < $this->departuredate)
//
//            $context->buildViolation('Date arrivée doit être supérieure ou égale à la date de départ ')
//                ->atPath('arriveddate')
//                ->addViolation();
//
//    }

    /**
     * Set reference
     *
     * @param string $reference
     *
     * @return Deplacement
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set cancelled
     *
     * @param boolean $cancelled
     *
     * @return Deplacement
     */
    public function setCancelled($cancelled)
    {
        $this->cancelled = $cancelled;

        return $this;
    }

    /**
     * Get cancelled
     *
     * @return boolean
     */
    public function getCancelled()
    {
        return $this->cancelled;
    }

    /**
     * Set reason
     *
     * @param string $reason
     *
     * @return Deplacement
     */
    public function setReason($reason)
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * Get reason
     *
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Set cancellable
     *
     * @param boolean $cancellable
     *
     * @return Deplacement
     */
    public function setCancellable($cancellale)
    {
        $this->cancellable = $cancellale;

        return $this;
    }

    /**
     * Get cancellable
     *
     * @return boolean
     */
    public function getCancellable()
    {
        return $this->cancellable;
    }

    public function validateDates()
    {
        if ($this->status == 'Arrivé' and $this->arriveddate < $this->departuredate) {

            return false;
        }
        return true;

    }
}
