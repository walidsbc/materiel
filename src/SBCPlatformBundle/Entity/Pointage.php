<?php

namespace SBCPlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Pointage
 *
 * @ORM\Table(name="pointage")
 * @ORM\Entity(repositoryClass="SBCPlatformBundle\Repository\PointageRepository")
 */
class Pointage
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
     * @var int
     *
     * @ORM\Column(name="usedduration", type="integer")
     */
    private $usedduration;

    /**
     * @ORM\ManyToOne(targetEntity="SBCPlatformBundle\Entity\Ouvrier")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pointedby;

    /**
     * @ORM\ManyToOne(targetEntity="SBCPlatformBundle\Entity\Materiel")
     * @ORM\JoinColumn(nullable=false)
     */
    private $materiel;


    /**
     * @ORM\ManyToOne(targetEntity="SBCPlatformBundle\Entity\Emplacement")
     * @ORM\JoinColumn(nullable=false)
     */
    private $emplacement;


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
     * @return Pointage
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
     * Set usedduration
     *
     * @param integer $usedduration
     *
     * @return Pointage
     */
    public function setUsedduration($usedduration)
    {
        $this->usedduration = $usedduration;

        return $this;
    }

    /**
     * Get usedduration
     *
     * @return int
     */
    public function getUsedduration()
    {
        return $this->usedduration;
    }

    /**
     * Set pointedby
     *
     * @param \SBCPlatformBundle\Entity\Ouvrier $pointedby
     *
     * @return Pointage
     */
    public function setPointedby(\SBCPlatformBundle\Entity\Ouvrier $pointedby)
    {
        $this->pointedby = $pointedby;

        return $this;
    }

    /**
     * Get pointedby
     *
     * @return \SBCPlatformBundle\Entity\Ouvrier
     */
    public function getPointedby()
    {
        return $this->pointedby;
    }

    /**
     * Set materiel
     *
     * @param \SBCPlatformBundle\Entity\Materiel $materiel
     *
     * @return Pointage
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
     * Set emplamcement
     *
     * @param \SBCPlatformBundle\Entity\Emplacement $emplacement
     *
     * @return Pointage
     */
    public function setEmplacement(\SBCPlatformBundle\Entity\Emplacement $emplacement)
    {
        $this->emplacement = $emplacement;

        return $this;
    }

    /**
     * Get emplacement
     *
     * @return \SBCPlatformBundle\Entity\Emplacement
     */
    public function getEmplacement()
    {
        return $this->emplacement;
    }
}
