<?php

namespace SBCPlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Fichier
 *
 * @ORM\Table(name="fichier")
 * @ORM\Entity(repositoryClass="SBCPlatformBundle\Repository\FichierRepository")
 * @Vich\Uploadable
 */
class Fichier
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
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;


    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="materiel_fichiers", fileNameProperty="fileName")
     * @Assert\File(
     *     mimeTypes = {"application/pdf", "application/x-pdf" },
     *     mimeTypesMessage = "Please upload a valid PDF "
     * )
     *
     * @var File
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $fileName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updatedAt;


    /**
     * @ORM\ManyToOne(targetEntity="SBCPlatformBundle\Entity\Materiel", inversedBy="files")
     * @ORM\JoinColumn(name="materiel_id", referencedColumnName="id")
     */
    protected $materiel;


    /**
     * Set imageName
     *
     * @param string $fileName
     *
     * @return Fichier
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $file
     *
     * @return Fichier
     */
    public function setFile(File $file = null)
    {
        $this->file = $file;

        if ($file) {
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getFile()
    {
        return $this->file;
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
     * Set description
     *
     * @param string $description
     *
     * @return Fichier
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Fichier
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set materiel
     *
     * @param \SBCPlatformBundle\Entity\Materiel $materiel
     *
     * @return Fichier
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
}
