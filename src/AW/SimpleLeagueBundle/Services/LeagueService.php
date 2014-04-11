<?php

namespace AW\SimpleLeagueBundle\Services;

use AW\HmacBundle\Exceptions\APIException;
use AW\SimpleLeagueBundle\Entity\League;

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
class LeagueService extends CrudService
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
        $this->setEntityName('League');
    }
    
    /**
     * Return the array of Leagues
     * 
     * @return array
     */
    public function getLeagues()
    {
        $leagues = array();
        $leaguesEm = $this->getRepo()->findAll();
        foreach ($leaguesEm as $league) {
            $leagues[] = $league;
        }
        
        return $leagues;
    }
    
    /**
     * Return a single league
     * 
     * @param integer $id League Id
     * 
     * @throws APIException
     * 
     * @return array
     */
    public function getLeague($id)
    {
        return $this->_getLeague($id);
    }
    
    /**
     * League creation
     * 
     * @param string $name Season Name
     * 
     * @throws APIException
     * 
     * @return \AW\SimpleLeagueBundle\Entity\League
     */
    public function createLeague($name)
    {
        return $this->create(
            array(
                'name' => $name
            )
        );
    }
    
    /**
     * Update a given with a given key value parameter set
     * 
     * @param integer $id     Season Id
     * @param array   $params Key/Val array of parameters
     * 
     * @return void
     */
    public function updateLeague($id, $params)
    {
        $league = $this->update($id, $params);
        $this->save($league);
    }
    
    /**
     * Get league object
     * 
     * @param integer $id League Id
     * 
     * @throws APIException
     * 
     * @return \AW\SimpleLeagueBundle\Entity\League
     */
    private function _getLeague($id)
    {
        return $this->getObject($id);
    }
}
