<?php
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 */
class LeagueUser
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** 
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $name;

    /** 
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $email;

    /** 
     * @ORM\Column(type="string", length=256, nullable=true)
     */
    private $password;

    /** 
     * @ORM\OneToMany(targetEntity="Activity", mappedBy="leagueUser")
     */
    private $activity;
}