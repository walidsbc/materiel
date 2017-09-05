<?php

namespace SBCPlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Fournisseur
 *
 * @ORM\Table(name="fournisseur")
 * @ORM\Entity(repositoryClass="SBCPlatformBundle\Repository\FournisseurRepository")
 */
class Fournisseur
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
     * @ORM\Column(name="companyname", type="string", length=255, unique=true)
     * @Assert\Length(min=2)
     */
    private $companyname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationdate", type="datetime")
     * @Assert\DateTime()
     */
    private $creationdate;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var int
     *
     * @ORM\Column(name="phonenumber", type="string", length=10, nullable=true, unique=true)
     * @Assert\Length(min=10, max=10)
     */
    private $phonenumber;

    /**
     * @var int
     *
     * @ORM\Column(name="faxnumber", type="string", length=10, nullable=true, unique=true)
     * @Assert\Length(min=10, max=10)
     */
    private $faxnumber;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

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
     * Set address
     *
     * @param string $address
     *
     * @return Fournisseur
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set phonenumber
     *
     * @param string $phonenumber
     *
     * @return Fournisseur
     */
    public function setPhonenumber($phonenumber)
    {
        $this->phonenumber = $phonenumber;

        return $this;
    }

    /**
     * Get phonenumber
     *
     * @return string
     */
    public function getPhonenumber()
    {
        return $this->phonenumber;
    }

    /**
     * Set faxnumber
     *
     * @param integer $faxnumber
     *
     * @return Fournisseur
     */
    public function setFaxnumber($faxnumber)
    {
        $this->faxnumber = $faxnumber;

        return $this;
    }

    /**
     * Get faxnumber
     *
     * @return int
     */
    public function getFaxnumber()
    {
        return $this->faxnumber;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Fournisseur
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set website
     *
     * @param string $website
     *
     * @return Fournisseur
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Fournisseur
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set creationdate
     *
     * @param \DateTime $creationdate
     *
     * @return Fournisseur
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
     * Set companyname
     *
     * @param string $companyname
     *
     * @return Fournisseur
     */
    public function setCompanyname($companyname)
    {
        $this->companyname = $companyname;

        return $this;
    }

    /**
     * Get companyname
     *
     * @return string
     */
    public function getCompanyname()
    {
        return $this->companyname;
    }

    public function __toString()
    {
        return $this->companyname;
    }
}
