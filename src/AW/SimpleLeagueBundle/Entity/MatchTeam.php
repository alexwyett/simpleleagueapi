<?php
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
     * @ORM\OneToMany(targetEntity="Score", mappedBy="matchTeam")
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
}