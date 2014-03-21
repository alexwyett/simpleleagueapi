<?php
namespace AW\SimpleLeagueBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 */
class LeagueUserClub
{
    /** 
     * @ORM\Column(type="integer", unique=true, nullable=false)
     */
    private $id;

    /** 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="LeagueUser", inversedBy="leagueUserClub")
     * @ORM\JoinColumn(name="league_user_id", referencedColumnName="id", nullable=false)
     */
    private $leagueUser;

    /** 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Club", inversedBy="leagueUserClub")
     * @ORM\JoinColumn(name="club_id", referencedColumnName="id", nullable=false)
     */
    private $club;

    /**
     * Set id
     *
     * @param integer $id
     * @return LeagueUserClub
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Set leagueUser
     *
     * @param \AW\SimpleLeagueBundle\Entity\LeagueUser $leagueUser
     * @return LeagueUserClub
     */
    public function setLeagueUser(\AW\SimpleLeagueBundle\Entity\LeagueUser $leagueUser)
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

    /**
     * Set club
     *
     * @param \AW\SimpleLeagueBundle\Entity\Club $club
     * @return LeagueUserClub
     */
    public function setClub(\AW\SimpleLeagueBundle\Entity\Club $club)
    {
        $this->club = $club;

        return $this;
    }

    /**
     * Get club
     *
     * @return \AW\SimpleLeagueBundle\Entity\Club 
     */
    public function getClub()
    {
        return $this->club;
    }
}
