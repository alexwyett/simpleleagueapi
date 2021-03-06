<?php
namespace AW\SimpleLeagueBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 */
class Club
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /** 
     * @ORM\OneToMany(targetEntity="Team", mappedBy="club")
     */
    private $team;

    /** 
     * @ORM\OneToMany(targetEntity="LeagueUserClub", mappedBy="club")
     */
    private $leagueUserClub;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->team = new \Doctrine\Common\Collections\ArrayCollection();
        $this->leagueUserClub = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Club
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
     * Add team
     *
     * @param \AW\SimpleLeagueBundle\Entity\Team $team
     * @return Club
     */
    public function addTeam(\AW\SimpleLeagueBundle\Entity\Team $team)
    {
        $this->team[] = $team;

        return $this;
    }

    /**
     * Remove team
     *
     * @param \AW\SimpleLeagueBundle\Entity\Team $team
     */
    public function removeTeam(\AW\SimpleLeagueBundle\Entity\Team $team)
    {
        $this->team->removeElement($team);
    }

    /**
     * Get team
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Add leagueUserClub
     *
     * @param \AW\SimpleLeagueBundle\Entity\LeagueUserClub $leagueUserClub
     * @return Club
     */
    public function addLeagueUserClub(\AW\SimpleLeagueBundle\Entity\LeagueUserClub $leagueUserClub)
    {
        $this->leagueUserClub[] = $leagueUserClub;

        return $this;
    }

    /**
     * Remove leagueUserClub
     *
     * @param \AW\SimpleLeagueBundle\Entity\LeagueUserClub $leagueUserClub
     */
    public function removeLeagueUserClub(\AW\SimpleLeagueBundle\Entity\LeagueUserClub $leagueUserClub)
    {
        $this->leagueUserClub->removeElement($leagueUserClub);
    }

    /**
     * Get leagueUserClub
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLeagueUserClub()
    {
        return $this->leagueUserClub;
    }
    
    /**
     * Array representation of a club
     * 
     * @return array
     */
    public function toArray()
    {
        $teams = array();
        foreach ($this->getTeam() as $team) {
            array_push($teams, $team->toArray());
        }
        
        return array(
            'id' => $this->getId(),
            'name' => $this->getName(),
            'teams' => $teams
        );
    }
}
