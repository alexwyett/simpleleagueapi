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
}