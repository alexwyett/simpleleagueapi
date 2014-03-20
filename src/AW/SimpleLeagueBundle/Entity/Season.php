<?php
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
}