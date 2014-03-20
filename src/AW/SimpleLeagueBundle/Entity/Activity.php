<?php
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="activity")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /** 
     * 
     * 
     */
    private $leagueUser;
}