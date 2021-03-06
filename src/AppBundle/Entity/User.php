<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Gedmo\Mapping\Annotation as Gedmo;
/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity()
 *
 */
class User
{
    /**
     * @var int
     * @JMS\Groups({"list", "details"})
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @JMS\Type("string")
     * @JMS\Groups({"list", "details"})
     * @ORM\Column(name="firstName", type="string", length=255)
     *
     */
    private $firstName;

    /**
     * @var string
     * @JMS\Type("string")
     * @JMS\Groups({"details"})
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    private $lastName;

    /**
     * @var string
     * @JMS\Type("string")
     * @JMS\Groups({"list", "details"})
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var bool
     * @JMS\Type("boolean")
     * @JMS\Groups({"details"})
     * @ORM\Column(name="state", type="boolean", nullable = true)
     */
    private $state = false;

    /**
     * @var \DateTime
     * @JMS\Type("DateTime")
     * @JMS\Groups({"list", "details"})
     * @ORM\Column(name="createdAt", type="datetime", nullable = true)
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @JMS\Type("AppBundle\Entity\Group")
     * @JMS\Groups({"details"})
     * @ORM\ManyToOne(targetEntity="Group", inversedBy="users", cascade={"persist"})
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     *
     */
    private $group;

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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
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
     * Set state
     *
     * @param boolean $state
     *
     * @return User
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return bool
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set group
     *
     * @param \AppBundle\Entity\Group $group
     *
     * @return User
     */
    public function setGroup(Group $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \AppBundle\Entity\Group
     */
    public function getGroup()
    {
        return $this->group;
    }
    
    public function __toString()
    {
        return $this->firstName;
    }
}
