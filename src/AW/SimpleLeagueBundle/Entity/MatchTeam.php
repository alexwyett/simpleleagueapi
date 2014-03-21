<?php
namespace AW\SimpleLeagueBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 */
class MatchTeam
{
    /** 
     * @ORM\Column(type="smallint", unique=true, length=1, nullable=false)
     */
    private $is_home;

    /** 
     * @ORM\OneToOne(targetEntity="Score", mappedBy="matchTeam")
     * @ORM\JoinColumn(name="score_id", referencedColumnName="id", unique=true)
     * @ORM\Id
     */
    private $score;

    /** 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Match", inversedBy="matchTeam")
     * @ORM\JoinColumn(name="match_id", referencedColumnName="id")
     */
    private $match;

    /** 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="matchTeam")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id")
     */
    private $team;

    /**
     * Set is_home
     *
     * @param integer $isHome
     * @return MatchTeam
     */
    public function setIsHome($isHome)
    {
        $this->is_home = $isHome;

        return $this;
    }

    /**
     * Get is_home
     *
     * @return integer 
     */
    public function getIsHome()
    {
        return $this->is_home;
    }

    /**
     * Set score
     *
     * @param \AW\SimpleLeagueBundle\Entity\Score $score
     * @return MatchTeam
     */
    public function setScore(\AW\SimpleLeagueBundle\Entity\Score $score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return \AW\SimpleLeagueBundle\Entity\Score 
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set match
     *
     * @param \AW\SimpleLeagueBundle\Entity\Match $match
     * @return MatchTeam
     */
    public function setMatch(\AW\SimpleLeagueBundle\Entity\Match $match)
    {
        $this->match = $match;

        return $this;
    }

    /**
     * Get match
     *
     * @return \AW\SimpleLeagueBundle\Entity\Match 
     */
    public function getMatch()
    {
        return $this->match;
    }

    /**
     * Set team
     *
     * @param \AW\SimpleLeagueBundle\Entity\Team $team
     * @return MatchTeam
     */
    public function setTeam(\AW\SimpleLeagueBundle\Entity\Team $team)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Get team
     *
     * @return \AW\SimpleLeagueBundle\Entity\Team 
     */
    public function getTeam()
    {
        return $this->team;
    }
}
