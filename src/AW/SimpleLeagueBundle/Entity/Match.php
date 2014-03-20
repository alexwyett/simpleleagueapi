<?php
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
     * @ORM\ManyToOne(targetEntity="Season", inversedBy="match")
     * @ORM\JoinColumn(name="season_id", referencedColumnName="id")
     */
    private $season;

    /** 
     * @ORM\ManyToMany(targetEntity="Team", mappedBy="match")
     */
    private $team;
}