<?php
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
}