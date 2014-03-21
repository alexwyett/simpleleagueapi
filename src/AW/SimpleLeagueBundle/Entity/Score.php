<?php
namespace AW\SimpleLeagueBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 */
class Score
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
    private $value;

    /** 
     * 
     * @ORM\JoinColumn(name="match_team_match_id", referencedColumnName="match_id", unique=true)
     * @ORM\ManyToOne(targetEntity="MatchTeam", inversedBy="score")
     * 
     */
    private $matchTeam;

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
     * Set value
     *
     * @param string $value
     * @return Score
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set matchTeam
     *
     * @param \AW\SimpleLeagueBundle\Entity\MatchTeam $matchTeam
     * @return Score
     */
    public function setMatchTeam(\AW\SimpleLeagueBundle\Entity\MatchTeam $matchTeam = null)
    {
        $this->matchTeam = $matchTeam;

        return $this;
    }

    /**
     * Get matchTeam
     *
     * @return \AW\SimpleLeagueBundle\Entity\MatchTeam 
     */
    public function getMatchTeam()
    {
        return $this->matchTeam;
    }
}
