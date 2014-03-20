<?php
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
     * @ORM\ManyToOne(targetEntity="MatchTeam", inversedBy="score")
     * @ORM\JoinColumn(name="match_team_match_id", referencedColumnName="match_id")
     * 
     */
    private $matchTeam;
}