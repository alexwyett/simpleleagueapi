<?php

namespace AW\SimpleLeagueBundle\Services;

use AW\HmacBundle\Exceptions\APIException;
use AW\SimpleLeagueBundle\Entity\Club;

/**
 * Handles Club/Team crud
 *
 * @category  Services
 * @package   AW
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2014 Alex Wyett
 * @license   All rights reserved
 * @link      http://www.wyett.co.uk
 */
class ClubService extends CrudService
{
    /**
     * Creates a new club service object
     *
     * @param \Doctrine\ORM\EntityManager $em The entity manager
     * 
     * @return void
     */
    public function __construct($em)
    {
        parent::__construct($em);
        $this->setBundleName('AWSimpleLeagueBundle');
        $this->setEntityName('Club');
    }
    
    /**
     * Return the array of Clubs
     * 
     * @return array
     */
    public function getClubs()
    {
        $clubs = array();
        $clubsEm = $this->getRepo()->findAll();
        foreach ($clubsEm as $club) {
            $clubs[] = $club;
        }
        
        return $clubs;
    }
    
    /**
     * Update a given with a given key value parameter set
     * 
     * @param integer $id     Club Id
     * @param array   $params Key/Val array of parameters
     * 
     * @return void
     */
    public function updateClub($id, $params)
    {
        $club = $this->_getClub($id);
        foreach ($params as $key => $val) {
            $func = 'set' . ucfirst($key);
            if (method_exists($club, $func)) {
                $club->$func($val);
            }
        }
        
        $this->save($club);
    }
    
    /**
     * Return a single club
     * 
     * @param integer $id club Id
     * 
     * @throws APIException
     * 
     * @return \AW\SimpleLeagueBundle\Entity\Club
     */
    public function getClub($id)
    {
        return $this->_getClub($id);
    }
    
    /**
     * Club creation
     * 
     * @param string $name Club Name
     * 
     * @throws APIException
     * 
     * @return \AW\SimpleLeagueBundle\Entity\Club
     */
    public function createClub($name)
    {
        $club = new Club();
        $club->setName($name);
        
        return $club;
    }
    
    /**
     * Get club object
     * 
     * @param integer $id Club Id
     * 
     * @throws APIException
     * 
     * @return \AW\SimpleLeagueBundle\Entity\Club
     */
    private function _getClub($id)
    {
        return $this->getObject($id);
    }
}
