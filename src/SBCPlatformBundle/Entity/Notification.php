<?php

namespace SBCPlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Notification
 *
 * @ORM\Table(name="notification")
 * @ORM\Entity(repositoryClass="SBCPlatformBundle\Repository\NotificationRepository")
 */
class Notification implements \JsonSerializable
{


    function jsonSerialize()
    {
        return get_object_vars($this);
    }


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
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\Length(min=2)
     */
    private $title;


    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=255)
     * @Assert\Length(min=2)
     */
    private $content;

    /**
     * @var array
     *
     * @ORM\Column(name="link", type="array", length=255)
     */
    private $link;


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
     * @ORM\Column(name="icon", type="string", length=255)
     * @Assert\Length(min=2)
     */
    private $icon;

    /**
     * @var string
     *
     * @ORM\Column(name="class", type="string", length=255)
     * @Assert\Length(min=2)
     */
    private $class;


    /**
     * @var boolean
     *
     * @ORM\Column(name="seen", type="boolean")
     */
    private $seen;




    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    public function __construct()
    {
        $this->creationdate = new \Datetime();
        $this->seen = false;

    }

    /**
     * Set creationdate
     *
     * @param \DateTime $creationdate
     *
     * @return Notification
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
     * Set seen
     *
     * @param boolean $seen
     *
     * @return Notification
     */
    public function setSeen($seen)
    {
        $this->seen = $seen;

        return $this;
    }

    /**
     * Get seen
     *
     * @return bool
     */
    public function getSeen()
    {
        return $this->seen;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Notification
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Notification
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set icon
     *
     * @param string $icon
     *
     * @return Notification
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set link
     *
     * @param array $link
     *
     * @return Notification
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return array
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set class
     *
     * @param string $class
     *
     * @return Notification
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get class
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }
}
