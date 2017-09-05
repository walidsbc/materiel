<?php

namespace SBCPlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Ouvrier
 *
 * @ORM\Table(name="ouvrier")
 * @ORM\Entity(repositoryClass="SBCPlatformBundle\Repository\OuvrierRepository")
 */
class Ouvrier
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * @Assert\Length(min=2)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255, unique=true, nullable=false)
     * @Assert\Length(min=2)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="cin", type="string", length=255, unique=true, nullable=false)
     * @Assert\Length(min=11, max=11)
     */
    private $cin;

    /**
     * @var string
     *
     * @ORM\Column(name="phonenumber", type="string", length=255, unique=true, nullable=false)
     * @Assert\Length(min=10, max=10)
     */
    private $phonenumber;


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
     * @return Ouvrier
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
     * Set code
     *
     * @param string $code
     *
     * @return Ouvrier
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set cin
     *
     * @param string $cin
     *
     * @return Ouvrier
     */
    public function setCin($cin)
    {
        $this->cin = $cin;

        return $this;
    }

    /**
     * Get cin
     *
     * @return string
     */
    public function getCin()
    {
        return $this->cin;
    }

    /**
     * Set phonenumber
     *
     * @param string $phonenumber
     *
     * @return Ouvrier
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

    public function __toString()
    {
        return $this->name;
    }
}
