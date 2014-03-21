<?php
namespace AW\SimpleLeagueBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(indexes={@ORM\Index(name="ActivityIndex", columns={"entity"})})
 */
class Activity
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** 
     * @ORM\Column(type="string", nullable=true)
     */
    private $entity;

    /** 
     * @ORM\Column(type="string", nullable=true)
     */
    private $activity;

    /** 
     * @ORM\ManyToOne(targetEntity="LeagueUser", inversedBy="activity")
     * @ORM\JoinColumn(name="league_user_id", referencedColumnName="id")
     */
    private $leagueUser;

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
     * Set entity
     *
     * @param string $entity
     * @return Activity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get entity
     *
     * @return string 
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Set activity
     *
     * @param string $activity
     * @return Activity
     */
    public function setActivity($activity)
    {
        $this->activity = $activity;

        return $this;
    }

    /**
     * Get activity
     *
     * @return string 
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * Set leagueUser
     *
     * @param \AW\SimpleLeagueBundle\Entity\LeagueUser $leagueUser
     * @return Activity
     */
    public function setLeagueUser(\AW\SimpleLeagueBundle\Entity\LeagueUser $leagueUser = null)
    {
        $this->leagueUser = $leagueUser;

        return $this;
    }

    /**
     * Get leagueUser
     *
     * @return \AW\SimpleLeagueBundle\Entity\LeagueUser 
     */
    public function getLeagueUser()
    {
        return $this->leagueUser;
    }
}
