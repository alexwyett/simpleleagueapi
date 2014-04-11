<?php

namespace AW\SimpleLeagueBundle\Services;

use AW\HmacBundle\Exceptions\APIException;
use AW\SimpleLeagueBundle\Entity\Match;
use AW\SimpleLeagueBundle\Entity\MatchTeam;

/**
 * Handles Match crud
 *
 * @category  Services
 * @package   AW
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2014 Alex Wyett
 * @license   All rights reserved
 * @link      http://www.wyett.co.uk
 */
class MatchService extends CrudService
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
        $this->setEntityName('Match');
    }
    
    /**
     * Create a new match
     * 
     * @param \AW\SimpleLeagueBundle\Entity\Team   $homeTeam Home Team
     * @param \AW\SimpleLeagueBundle\Entity\Team   $awayTeam Away Team
     * @param \AW\SimpleLeagueBundle\Entity\Season $season   Match Season
     * @param \DateTime                            $date     Match Date
     * 
     * @return \AW\SimpleLeagueBundle\Entity\Match
     */
    public function createMatch($homeTeam, $awayTeam, $season, $date)
    {
        $match = new Match();
        $match->setSeason($season);
        $match->setStartDate($date);
        
        $home = new MatchTeam();
        $home->setTeam($homeTeam);
        $home->setIsHome(true);
        $home->setMatch($match);
        
        $away = new MatchTeam();
        $away->setTeam($awayTeam);
        $away->setMatch($match);
        
        return $match;
    }
    
    /**
     * Create a new match
     * 
     * @param \AW\SimpleLeagueBundle\Entity\Match  $match    Current match
     * @param \AW\SimpleLeagueBundle\Entity\Team   $homeTeam Home Team
     * @param \AW\SimpleLeagueBundle\Entity\Team   $awayTeam Away Team
     * @param \AW\SimpleLeagueBundle\Entity\Season $season   Match Season
     * @param \DateTime                            $date     Match Date
     * 
     * @return \AW\SimpleLeagueBundle\Entity\Match
     */
    public function updateMatch($match, $homeTeam, $awayTeam, $season, $date)
    {
        $match->setSeason($season);
        $match->setStartDate($date);
        
        return $match;
    }
    
    /**
     * Return a single match
     * 
     * @param integer $id Match ID
     * 
     * @return \AW\SimpleLeagueBundle\Entity\Match
     */
    public function getMatch($id)
    {
        return $this->_getMatch($id);
    }
    
    /**
     * Get match object
     * 
     * @param integer $id Match Id
     * 
     * @throws APIException
     * 
     * @return \AW\SimpleLeagueBundle\Entity\Match
     */
    private function _getMatch($id)
    {
        return $this->getObject($id);
    }
}
