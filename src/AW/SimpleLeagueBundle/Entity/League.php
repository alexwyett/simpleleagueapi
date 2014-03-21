<?php
namespace AW\SimpleLeagueBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 */
class League
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
     * @ORM\OneToMany(targetEntity="Season", mappedBy="league")
     */
    private $season;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->season = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return League
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
     * Add season
     *
     * @param \AW\SimpleLeagueBundle\Entity\Season $season
     * @return League
     */
    public function addSeason(\AW\SimpleLeagueBundle\Entity\Season $season)
    {
        $this->season[] = $season;

        return $this;
    }

    /**
     * Remove season
     *
     * @param \AW\SimpleLeagueBundle\Entity\Season $season
     */
    public function removeSeason(\AW\SimpleLeagueBundle\Entity\Season $season)
    {
        $this->season->removeElement($season);
    }

    /**
     * Get season
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSeason()
    {
        return $this->season;
    }
}
