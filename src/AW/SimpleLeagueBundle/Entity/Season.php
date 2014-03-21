<?php
namespace AW\SimpleLeagueBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 */
class Season
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
     * @ORM\OneToMany(targetEntity="Match", mappedBy="season")
     */
    private $match;

    /** 
     * @ORM\ManyToOne(targetEntity="League", inversedBy="season")
     * @ORM\JoinColumn(name="league_id", referencedColumnName="id")
     */
    private $league;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->match = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Season
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
     * Add match
     *
     * @param \AW\SimpleLeagueBundle\Entity\Match $match
     * @return Season
     */
    public function addMatch(\AW\SimpleLeagueBundle\Entity\Match $match)
    {
        $this->match[] = $match;

        return $this;
    }

    /**
     * Remove match
     *
     * @param \AW\SimpleLeagueBundle\Entity\Match $match
     */
    public function removeMatch(\AW\SimpleLeagueBundle\Entity\Match $match)
    {
        $this->match->removeElement($match);
    }

    /**
     * Get match
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMatch()
    {
        return $this->match;
    }

    /**
     * Set league
     *
     * @param \AW\SimpleLeagueBundle\Entity\League $league
     * @return Season
     */
    public function setLeague(\AW\SimpleLeagueBundle\Entity\League $league = null)
    {
        $this->league = $league;

        return $this;
    }

    /**
     * Get league
     *
     * @return \AW\SimpleLeagueBundle\Entity\League 
     */
    public function getLeague()
    {
        return $this->league;
    }
}
