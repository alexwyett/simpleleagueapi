<?php

namespace AW\SimpleLeagueBundle\Services;

use AW\HmacBundle\Exceptions\APIException;
use AW\SimpleLeagueBundle\Entity\Season;

/**
 * Handles Season crud
 *
 * @category  Services
 * @package   AW
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2014 Alex Wyett
 * @license   All rights reserved
 * @link      http://www.wyett.co.uk
 */
class SeasonService extends CrudService
{
    /**
     * Creates a new Season service object
     *
     * @param \Doctrine\ORM\EntityManager $em The entity manager
     * 
     * @return void
     */
    public function __construct($em)
    {
        parent::__construct($em);
        $this->setBundleName('AWSimpleLeagueBundle');
        $this->setEntityName('Season');
    }
    
    /**
     * Return the array of Seasons
     * 
     * @return array
     */
    public function getSeasons()
    {
        $seasons = array();
        $seasonsEm = $this->getRepo()->findAll();
        foreach ($seasonsEm as $season) {
            $seasons[] = $season;
        }
        
        return $seasons;
    }
    
    /**
     * Return a single season
     * 
     * @param integer $id season Id
     * 
     * @throws APIException
     * 
     * @return array
     */
    public function getSeason($id)
    {
        return $this->_getSeason($id);
    }
    
    /**
     * Season creation
     * 
     * @param \AW\SimpleLeagueBundle\Entity\League $league Parent League
     * @param string                               $name   Season Name
     * @param \DateTime                            $start  Starting Date
     * 
     * @throws APIException
     * 
     * @return \AW\SimpleLeagueBundle\Entity\Season
     */
    public function createSeason($league, $name, $start)
    {
        return $this->create(
            array(
                'league' => $league,
                'name' => $name,
                'startDate' => $start
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
    public function updateSeason($id, $params)
    {
        $season = $this->update($id, $params);
        $this->save($season);
    }
    
    /**
     * Get season object
     * 
     * @param integer $id Season Id
     * 
     * @throws APIException
     * 
     * @return \AW\SimpleLeagueBundle\Entity\Season
     */
    private function _getSeason($id)
    {
        return $this->getObject($id);
    }
}
