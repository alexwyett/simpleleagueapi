<?php
namespace AW\SimpleLeagueBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(indexes={@ORM\Index(name="ActivityIndex", columns={"entity"})})
 */
class Activity
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** 
     * @ORM\Column(type="string", nullable=true)
     */
    private $entity;

    /** 
     * @ORM\Column(type="string", nullable=true)
     */
    private $activity;

    /** 
     * 
     * 
     */
    private $user;

    /** 
     * 
     * 
     @ORM\ManyToOne(targetEntity="LeagueUser", inversedBy="activity")
     @ORM\JoinColumn(name="league_user_id", referencedColumnName="id")*/
    private $leagueUser;
}