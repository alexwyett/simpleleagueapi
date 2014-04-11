<?php

namespace AW\SimpleLeagueBundle\Services;

use AW\HmacBundle\Exceptions\APIException;
use AW\SimpleLeagueBundle\Entity\Team;

/**
 * Handles Team crud
 *
 * @category  Services
 * @package   AW
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2014 Alex Wyett
 * @license   All rights reserved
 * @link      http://www.wyett.co.uk
 */
class TeamService extends CrudService
{
    /**
     * Creates a new Team service object
     *
     * @param \Doctrine\ORM\EntityManager $em The entity manager
     * 
     * @return void
     */
    public function __construct($em)
    {
        parent::__construct($em);
        $this->setBundleName('AWSimpleLeagueBundle');
        $this->setEntityName('Team');
    }
    
    /**
     * Return the array of Teams
     * 
     * @return array
     */
    public function getTeams()
    {
        $teams = array();
        $teamsEm = $this->getRepo()->findAll();
        foreach ($teamsEm as $team) {
            $teams[] = $team;
        }
        
        return $teams;
    }
    
    /**
     * Return a single team
     * 
     * @param integer $id team Id
     * 
     * @throws APIException
     * 
     * @return array
     */
    public function getTeam($id)
    {
        return $this->_getTeam($id);
    }
    
    /**
     * Team creation
     * 
     * @param \AW\SimpleLeagueBundle\Entity\Club $club Parent Club
     * @param string                             $team Team Name
     * 
     * @throws APIException
     * 
     * @return \AW\SimpleLeagueBundle\Entity\Team
     */
    public function createTeam($club, $name)
    {
        $team = new Team();
        $team->setName($name);
        $team->setClub($club);
        
        return $team;
    }
    
    /**
     * Update a given with a given key value parameter set
     * 
     * @param integer $id     Team Id
     * @param array   $params Key/Val array of parameters
     * 
     * @return void
     */
    public function updateTeam($id, $params)
    {
        $team = $this->_getTeam($id);
        foreach ($params as $key => $val) {
            $func = 'set' . ucfirst($key);
            if (method_exists($team, $func)) {
                $team->$func($val);
            }
        }
        
        $this->save($team);
    }
    
    /**
     * Get team object
     * 
     * @param integer $id team Id
     * 
     * @throws APIException
     * 
     * @return \AW\SimpleLeagueBundle\Entity\Team
     */
    private function _getTeam($id)
    {
        return $this->getObject($id);
    }
}
