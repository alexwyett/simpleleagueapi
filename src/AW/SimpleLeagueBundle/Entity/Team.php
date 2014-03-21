<?php
namespace AW\SimpleLeagueBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 */
class Team
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
     * @ORM\OneToMany(targetEntity="MatchTeam", mappedBy="team")
     */
    private $matchTeam;

    /** 
     * @ORM\ManyToOne(targetEntity="Club", inversedBy="team")
     * @ORM\JoinColumn(name="club_id", referencedColumnName="id")
     */
    private $club;

    /** 
     * 
     * 
     */
    private $match;
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
     * Set name
     *
     * @param string $name
     * @return Team
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
     * Add matchTeam
     *
     * @param \AW\SimpleLeagueBundle\Entity\MatchTeam $matchTeam
     * @return Team
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
     * Set club
     *
     * @param \AW\SimpleLeagueBundle\Entity\Club $club
     * @return Team
     */
    public function setClub(\AW\SimpleLeagueBundle\Entity\Club $club = null)
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
