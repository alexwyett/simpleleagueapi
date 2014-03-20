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
     * @ORM\ManyToOne(targetEntity="Club", inversedBy="team")
     * @ORM\JoinColumn(name="club_id", referencedColumnName="id")
     */
    private $club;

    /** 
     * @ORM\ManyToMany(targetEntity="Match", inversedBy="team")
     * @ORM\JoinTable(
     *     name="MatchTeam", 
     *     joinColumns={@ORM\JoinColumn(name="team_id", referencedColumnName="id", nullable=false)}, 
     *     inverseJoinColumns={@ORM\JoinColumn(name="match_id", referencedColumnName="id", nullable=false)}
     * )
     */
    private $match;
}