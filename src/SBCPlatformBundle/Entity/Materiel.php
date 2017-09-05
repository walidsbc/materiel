<?php

namespace SBCPlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Materiel
 *
 * @ORM\Table(name="materiel")
 * @ORM\Entity(repositoryClass="SBCPlatformBundle\Repository\MaterielRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable
 *
 */
class Materiel
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
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=255, unique=true)
     * @Assert\Length(min=2)
     */
    private $reference;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="buydate", type="datetime")
     * @Assert\DateTime()
     */
    private $buydate;

    /**
     * @var int
     *
     * @ORM\Column(name="buyprice", type="decimal", precision=10, scale=3)
     */
    private $buyprice;

    /**
     * @var int
     *
     * @ORM\Column(name="lifetime", type="integer")
     */
    private $lifetime;

    /**
     * @var int
     *
     * @ORM\Column(name="unitcost", type="decimal", precision=10, scale=3)
     */
    private $unitcost;

    /**
     * @ORM\OneToMany(targetEntity="SBCPlatformBundle\Entity\Deplacement", mappedBy="materiel")
     */
    private $deplacements;

    /**
     * @ORM\ManyToOne(targetEntity="SBCPlatformBundle\Entity\Fournisseur")
     */
    private $fournisseur;

    /**
     * @var string
     *
     * @ORM\Column(name="registration", type="string", length=255, unique=true, nullable=true)
     * @Assert\Length(min=2)
     */
    private $registration;

    /**
     * @var string
     *
     * @ORM\Column(name="serialnumber", type="string", length=255, unique=true, nullable=true)
     * @Assert\Length(min=2)
     */
    private $serialnumber;

    /**
     * @var int
     *
     * @ORM\Column(name="lifetimeconsumed", type="integer", nullable=false)
     * @Assert\Length(min=1)
     */
    private $lifetimeconsumed;

    /**
     * @var int
     *
     * @ORM\Column(name="lifetimeremaining", type="integer", nullable=false)
     * @Assert\Length(min=1)
     */
    private $lifetimeremaining;

//    /**
//     * NOTE: This is not a mapped field of entity metadata, just a simple property.
//     *
//     * @Vich\UploadableField(mapping="materiel_facture", fileNameProperty="factureName")
//     * @Assert\File(
//     *     mimeTypes = {"application/pdf", "application/x-pdf" , "image/png", "image/jpeg", "image/jpg"},
//     *     mimeTypesMessage = "Please upload a valid PDF or valid IMAGE"
//     * )
//     *
//     * @var File
//     */
//    private $factureFile;
//
//    /**
//     * @ORM\Column(type="string", length=255, nullable=true)
//     *
//     * @var string
//     */
//    private $factureName;

    /**
     * @ORM\OneToMany(targetEntity="SBCPlatformBundle\Entity\Fichier", mappedBy="materiel", cascade={"persist", "merge", "remove"})
     * @ORM\JoinColumn(name="file_id", referencedColumnName="id")
     * @Assert\Valid()
     */

    private $files;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activated", type="boolean", nullable=false)
     */
    private $activated;


    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     * @Assert\Length(min=2)
     */
    private $status;

    /**
     * @var ArrayCollection $typeinterventions
     *
     * @ORM\OneToMany(targetEntity="SBCPlatformBundle\Entity\PlanificationPrevention", mappedBy="materiel", cascade={"persist", "remove", "merge"})
     */
    private $planifications;


    public function __construct()
    {

        $this->files = new ArrayCollection();
        $this->planifications = new ArrayCollection();
        $this->lifetimeconsumed = 0;
        $this->lifetimeremaining = 0;
        $this->activated = 1;
        $this->deplacements = new ArrayCollection();


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
     * @return Materiel
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
     * Set reference
     *
     * @param string $reference
     *
     * @return Materiel
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
     * Set buydate
     *
     * @param \DateTime $buydate
     *
     * @return Materiel
     */
    public function setBuydate($buydate)
    {
        $this->buydate = $buydate;

        return $this;
    }

    /**
     * Get buydate
     *
     * @return \DateTime
     */
    public function getBuydate()
    {


        return $this->buydate;


    }

    /**
     * Set lifetime
     *
     * @param integer $lifetime
     *
     * @return Materiel
     */
    public function setLifetime($lifetime)
    {
        $this->lifetime = $lifetime;

        return $this;
    }

    /**
     * Get lifetime
     *
     * @return int
     */
    public function getLifetime()
    {
        return $this->lifetime;
    }

    /**
     * @param Deplacement $deplacement
     * @return Materiel
     */
    public function addDeplacement(Deplacement $deplacement)
    {
        $this->deplacements[] = $deplacement;


        $deplacement->setMateriel($this);

        return $this;
    }

    /**
     * @param Deplacement $deplacement
     */
    public function removeDeplacement(Deplacement $deplacement)
    {
        $this->deplacements->removeElement($deplacement);

        // Et si notre relation était facultative (nullable=true, ce qui n'est pas notre cas ici attention) :
        // $application->setAdvert(null);
    }

    /**
     * @return ArrayCollection
     */
    public function getDeplacements()
    {
        return $this->deplacements;
    }

    /**
     * Set fournisseur
     *
     * @param \SBCPlatformBundle\Entity\Fournisseur $fournisseur
     *
     * @return Materiel
     */
    public function setFournisseur(\SBCPlatformBundle\Entity\Fournisseur $fournisseur = null)
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    /**
     * Get fournisseur
     *
     * @return \SBCPlatformBundle\Entity\Fournisseur
     */
    public function getFournisseur()
    {
        return $this->fournisseur;
    }

    /**
     * Set buyprice
     *
     * @param string $buyprice
     *
     * @return Materiel
     */
    public function setBuyprice($buyprice)
    {
        $this->buyprice = $buyprice;

        return $this;
    }

    /**
     * Get buyprice
     *
     * @return string
     */
    public function getBuyprice()
    {
        return $this->buyprice;
    }

    /**
     * Set unitcost
     *
     * @param string $unitcost
     *
     * @return Materiel
     */
    public function setUnitcost($unitcost)
    {
        $this->unitcost = $unitcost;

        return $this;
    }

    /**
     * Get unitcost
     *
     * @return string
     */
    public function getUnitcost()
    {
        return $this->unitcost;
    }

    /**
     * Set registration
     *
     * @param string $registration
     *
     * @return Materiel
     */
    public function setRegistration($registration)
    {
        $this->registration = $registration;

        return $this;
    }

    /**
     * Get registration
     *
     * @return string
     */
    public function getRegistration()
    {
        return $this->registration;
    }

    /**
     * Set serialnumber
     *
     * @param string $serialnumber
     *
     * @return Materiel
     */
    public function setSerialnumber($serialnumber)
    {
        $this->serialnumber = $serialnumber;

        return $this;
    }

    /**
     * Get serialnumber
     *
     * @return string
     */
    public function getSerialnumber()
    {
        return $this->serialnumber;
    }

//    /**
//     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $facture
//     *
//     * @return Materiel
//     */
//    public function setFactureFile(File $facture = null)
//    {
//        $this->factureFile = $facture;
//        return $this;
//    }
//
//    /**
//     * @return File|null
//     */
//    public function getFactureFile()
//    {
//        return $this->factureFile;
//    }
//
//    /**
//     * @param string $factureName
//     *
//     * @return Materiel
//     */
//    public function setFactureName($factureName)
//    {
//        $this->factureName = $factureName;
//
//        return $this;
//    }
//
//    /**
//     * @return string|null
//     */
//    public function getFactureName()
//    {
//        return $this->factureName;
//    }


    public function addFile(Fichier $file)
    {
        $file->setMateriel($this);
        $this->files[] = $file;


        return $this;
    }

    public function removeFile(Fichier $file)
    {
        $this->files->removeElement($file);
    }

    public function getFiles()
    {
        return $this->files;
    }

//    public function setFiles(ArrayCollection $files)
//{
//    foreach ($files as $file) {
//        $file->setProperty($this);
//    }
//
//    $this->files = $files;
//}


    /**
     * Set lifetimeconsumed
     *
     * @param integer $lifetimeconsumed
     *
     * @return Materiel
     */
    public function setLifetimeconsumed($lifetimeconsumed)
    {
        $this->lifetimeconsumed = $lifetimeconsumed;

        return $this;
    }

    /**
     * Get lifetimeconsumed
     *
     * @return integer
     */
    public function getLifetimeconsumed()
    {
        return $this->lifetimeconsumed;
    }

    /**
     * Set lifetimeremaining
     *
     * @param integer $lifetimeremaining
     *
     * @return Materiel
     *
     *
     * @ORM\PrePersist()
     */
    public function setLifetimeremaining()
    {
        $this->lifetimeremaining = $this->lifetime;

        return $this;
    }

    /**
     * Set lifetimeremaining
     *
     *
     * @return Materiel
     *
     *
     * @ORM\PreUpdate
     *
     */
    public function setLifetimeremaining2()
    {
        $this->lifetimeremaining = $this->lifetime - $this->lifetimeconsumed;

        return $this;
    }

    /**
     * Get lifetimeremaining
     *
     * @return integer
     */
    public function getLifetimeremaining()
    {
        return $this->lifetimeremaining;
    }


    /**
     * Set activated
     *
     * @param boolean $activated
     *
     * @return Materiel
     */
    public function setActivated($activated)
    {
        $this->activated = $activated;

        return $this;
    }

    /**
     * Get activated
     *
     * @return boolean
     */
    public function getActivated()
    {
        return $this->activated;
    }


    /**
     * Set status
     *
     * @param string $status
     *
     * @return Materiel
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

    public function __toString()
    {
        return $this->name;
    }


    public function addPlanification(PlanificationPrevention $planification)
    {
        $planification->setMateriel($this);
        $this->planifications[] = $planification;

        //for update
//        $this->planifications->add($planification);


        return $this;
    }

    public function removePlanification(PlanificationPrevention $planification)
    {
        $this->planifications->removeElement($planification);
    }

    /**
     * @return ArrayCollection $planification
     */
    public function getPlanifications()
    {
        return $this->planifications;
    }


}
