<?php
namespace AW\SimpleLeagueBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 */
class Match
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** 
     * @ORM\Column(type="date", nullable=true)
     */
    private $startDate;

    /** 
     * @ORM\OneToMany(targetEntity="MatchTeam", mappedBy="match")
     */
    private $matchTeam;

    /** 
     * @ORM\ManyToOne(targetEntity="Season", inversedBy="match")
     * @ORM\JoinColumn(name="season_id", referencedColumnName="id")
     */
    private $season;

    /** 
     * 
     */
    private $team;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->matchTeam = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return Match
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Add matchTeam
     *
     * @param \AW\SimpleLeagueBundle\Entity\MatchTeam $matchTeam
     * @return Match
     */
    public function addMatchTeam(\AW\SimpleLeagueBundle\Entity\MatchTeam $matchTeam)
    {
        $this->matchTeam[] = $matchTeam;

        return $this;
    }

    /**
     * Remove matchTeam
     *
     * @param \AW\SimpleLeagueBundle\Entity\MatchTeam $matchTeam
     */
    public function removeMatchTeam(\AW\SimpleLeagueBundle\Entity\MatchTeam $matchTeam)
    {
        $this->matchTeam->removeElement($matchTeam);
    }

    /**
     * Get matchTeam
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMatchTeam()
    {
        return $this->matchTeam;
    }

    /**
     * Set season
     *
     * @param \AW\SimpleLeagueBundle\Entity\Season $season
     * @return Match
     */
    public function setSeason(\AW\SimpleLeagueBundle\Entity\Season $season = null)
    {
        $this->season = $season;

        return $this;
    }

    /**
     * Get season
     *
     * @return \AW\SimpleLeagueBundle\Entity\Season 
     */
    public function getSeason()
    {
        return $this->season;
    }
}
