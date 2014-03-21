<?php
namespace AW\SimpleLeagueBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 */
class LeagueUser
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** 
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $name;

    /** 
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $email;

    /** 
     * @ORM\Column(type="string", length=256, nullable=true)
     */
    private $password;

    /** 
     * @ORM\OneToMany(targetEntity="Activity", mappedBy="leagueUser")
     */
    private $activity;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->activity = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return LeagueUser
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
     * Set email
     *
     * @param string $email
     * @return LeagueUser
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
     * Set password
     *
     * @param string $password
     * @return LeagueUser
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Add activity
     *
     * @param \AW\SimpleLeagueBundle\Entity\Activity $activity
     * @return LeagueUser
     */
    public function addActivity(\AW\SimpleLeagueBundle\Entity\Activity $activity)
    {
        $this->activity[] = $activity;

        return $this;
    }

    /**
     * Remove activity
     *
     * @param \AW\SimpleLeagueBundle\Entity\Activity $activity
     */
    public function removeActivity(\AW\SimpleLeagueBundle\Entity\Activity $activity)
    {
        $this->activity->removeElement($activity);
    }

    /**
     * Get activity
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getActivity()
    {
        return $this->activity;
    }
}
